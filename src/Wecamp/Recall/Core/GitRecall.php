<?php

namespace Wecamp\Recall\Core;

use Wecamp\Recall\Core\Data\Json;
use Wecamp\Recall\Git\GitWrapper;

class GitRecall implements Recallable
{
    /**
     * @var GitWrapper
     */
    private $gitWrapper;

    /**
     * @var string
     */
    private $dataDir;

    /**
     * @param GitWrapper $gitWrapper
     * @param string $dataDir
     */
    public function __construct(GitWrapper $gitWrapper, $dataDir)
    {
        $this->gitWrapper = $gitWrapper;
        $this->dataDir = $dataDir;

        $this->openWorkingCopy();
    }

    /**
     * Adds an Entity
     *
     * @param  Entry $entry
     * @param  User $user
     * @param  string $description
     * @param null $version
     * @return Entry
     */
    public function addEntry(Entry $entry, User $user, $description, $version = null)
    {
        $this->checkoutVersion($version);
        $this->createFile($entry);
        $this->commitFile($entry, $user, $description);

        return $entry;
    }

    /**
     * Returns an entity for a given Context located by it's identifier
     *
     * @param  Context $context
     * @param  Identifier $identifier
     * @param  string|null $version
     * @return Entry
     */
    public function getEntry(Context $context, Identifier $identifier, $version = null)
    {
        $this->checkoutVersion($version);
        return $this->readFile($context, $identifier);
    }

    /**
     * @return string $uuid
     */
    public function changeRequest()
    {
        // Always branch from master
        $this->checkoutVersion();
        return $this->branch();
    }

    /**
     * @return \string[]
     */
    public function listChangeRequests()
    {
        return $this->listBranches();
    }

    /**
     * @param string $branch
     */
    public function acceptChangeRequest($branch)
    {
        $this->checkoutVersion(null);
        $this->merge($branch);
        $this->delete($branch);
    }

    /**
     * @param string $branch
     */
    public function denyChangeRequest($branch)
    {
        $this->delete($branch);
    }

    /**
     * Recalls the whole timeline for a certain Context
     * If no Context is given, a wildcard is assumed.
     * A.k.a. Total Recall
     *
     * @param  Context $context
     * @param string $branch
     * @return Timeline
     */
    public function recallTimeline(Context $context = null, $branch = 'master')
    {
        $this->checkoutVersion($branch);

        $log = $this->readLog($context);
        $logStats = $this->readLogStats($context);

        $logEvents = $this->parseLog($log, $logStats);

        return $this->createTimeline($logEvents);
    }

    /**
     * @return string $uuid
     */
    private function branch()
    {
        $uuid = (string) \Rhumsaa\Uuid\Uuid::uuid4();
        $this->gitWrapper->checkoutNewBranch($uuid);
        return $uuid;
    }

    /**
     * @param string $branch
     */
    private function merge($branch)
    {
        $this->gitWrapper->merge($branch);
    }

    /**
     * @param string $branch
     */
    private function delete($branch)
    {
        $this->checkoutVersion();
        $this->gitWrapper->branch($branch, array('D' => true));
    }

    /**
     * @return string[]
     */
    private function listBranches()
    {
        $branches = $this->gitWrapper->getBranches()->fetchBranches();
        foreach($branches as $key => $value) {
            if($value == 'master') {
                unset($branches[$key]);
            }
        }
        return array_values($branches);
    }

    /**
     * @throws \RuntimeException
     */
    private function openWorkingCopy()
    {
        if (!is_dir($this->dataDir)) {
            if (@mkdir($this->dataDir, 0755, true) === false) {
                throw new \RuntimeException(sprintf('Unable to create directory %s', $this->dataDir));
            }

            $this->gitWrapper->init($this->dataDir);

            if (@touch($this->dataDir . '/README.md') === false) {
                throw new \RuntimeException(sprintf('Unable to write file %s', $this->dataDir . '/README.md'));
            }

            $this->gitWrapper->setUser('Recall System', 'system@recall.com');
            $this->gitWrapper->add('README.md');
            $this->gitWrapper->commit('Added readme');
        }

        $this->gitWrapper->workingCopy($this->dataDir);
    }

    /**
     * @param Entry $entry
     * @throws \RuntimeException
     */
    private function createFile(Entry $entry)
    {
        $dir = sprintf('%s/%s', $this->dataDir, $entry->getContext());
        if (!is_dir($dir)) {
            if (@mkdir($dir, 0755, true) === false) {
                throw new \RuntimeException(sprintf('Unable to create directory %s', $dir));
            }
        }

        $file = sprintf('%s/%s/%s.json', $this->dataDir, $entry->getContext(), $entry->getIdentifier());

        if (@file_put_contents($file, json_encode($entry->getData()->getData(), JSON_PRETTY_PRINT)) === false) {
            throw new \RuntimeException(sprintf('Unable to write file %s', $file));
        }
    }

    /**
     * @param Entry $entry
     * @param User $user
     * @param string $description The commit message
     */
    private function commitFile(Entry $entry, User $user, $description)
    {
        if ($this->gitWrapper->hasChanges()) {
            $this->gitWrapper->setUser($user->getName(), $user->getEmail());
            $this->gitWrapper->add(sprintf('%s/%s.json', $entry->getContext(), $entry->getIdentifier()));
            $this->gitWrapper->commit($description);
        }
    }

    /**
     * @param Context $context
     * @param Identifier $identifier
     * @return Entry
     * @throws \RuntimeException
     */
    private function readFile(Context $context, Identifier $identifier)
    {
        $file = sprintf('%s/%s/%s.json', $this->dataDir, $context, $identifier);
        $rawData = @file_get_contents($file);

        if ($rawData === false) {
            throw new \RuntimeException(sprintf('Unable to read file %s', $file));
        }

        return new Entry($context, $identifier, new Json($rawData));
    }

    /**
     * @param string|null $version
     */
    private function checkoutVersion($version = null)
    {
        if (!$version) {
            $version = 'master';
        }

        $this->gitWrapper->checkout($version);
    }

    /**
     * @param Context|null $context
     * @return string
     */
    private function readLog(Context $context = null)
    {
        $this->gitWrapper->clearOutput();

        if ($context) {
            $this->gitWrapper->log('--name-status', $context->getName());
        } else {
            $this->gitWrapper->log('--name-status');
        }

        return $this->gitWrapper->getOutput();
    }

    /**
     * @param Context|null $context
     * @return string
     */
    private function readLogStats(Context $context = null)
    {
        $this->gitWrapper->clearOutput();

        $this->gitWrapper->log('--stat');

        return $this->gitWrapper->getOutput();
    }

    /**
     * @param string $log
     * @param string $logStats
     * @return array
     */
    private function parseLog($log, $logStats)
    {
        $events = array();

        $logBlocks = preg_split('/(?:^|\n)commit /', $log, -1, PREG_SPLIT_NO_EMPTY);
        $logStatsBlocks = preg_split('/(?:^|\n)commit /', $logStats, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($logBlocks as $block) {
            if (preg_match('/^(.+?)\n/', $block, $m)) {
                $commit = $m[1];

                preg_match('/Date: +(.+?)\n/', $block, $m);
                $date = $m[1];

                preg_match('/Author: +(.+?) <(.+?)>/', $block, $m);
                $name = $m[1];
                $email = $m[2];

                if(!preg_match('/\n\n +(.+)\n\n/', $block, $m)) {
                    continue;
                }

                $message = $m[1];

                preg_match('/\n([AMD])(?:\t| {7})(.+?)(?:\n|$)/', $block, $m);
                $action = $m[1];
                $file = $m[2];

                $insertions = 0;
                $deletions = 0;

                foreach ($logStatsBlocks as $statsBlock) {
                    if (strpos($statsBlock, $commit) === 0) {
                        if (preg_match('/(\d+) insertion/', $statsBlock, $m)) {
                            $insertions = (int)$m[1];
                        }
                        if (preg_match('/(\d+) deletion/', $statsBlock, $m)) {
                            $deletions = (int)$m[1];
                        }
                    }
                }

                $events[] = array(
                    'commit' => $commit,
                    'date' => $date,
                    'user_name' => $name,
                    'user_email' => $email,
                    'message' => $message,
                    'action' => $action,
                    'file' => $file,
                    'insertions' => $insertions,
                    'deletions' => $deletions
                );
            }
        }

        return $events;
    }

    /**
     * @param array $logEvents
     * @return Timeline
     */
    private function createTimeline(array $logEvents)
    {
        $events = array();

        foreach ($logEvents as $logEvent) {
            if (!preg_match('|^(.+)/(.+?)\.json$|', $logEvent['file'], $m)) {
                continue;
            }

            $user = new User($logEvent['user_name'], $logEvent['user_email']);
            $date = new \DateTime($logEvent['date']);
            $context = new Context($m[1]);
            $identifier = new Identifier($m[2]);

            $events[] = new Event(
                $logEvent['commit'],
                $user,
                $date->getTimestamp(),
                $logEvent['message'],
                $logEvent['insertions'],
                $logEvent['deletions'],
                $context,
                $identifier
            );
        }

        return new Timeline($events);
    }
}
