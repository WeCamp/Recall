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
     * @return Entry
     */
    public function addEntry(Entry $entry, User $user)
    {
        $this->createFile($entry);
        $this->commitFile($entry, $user);
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
     * Recalls the whole timeline for a certain Context
     * If no Context is given, a wildcard is assumed.
     * A.k.a. Total Recall
     *
     * @param  Context $context
     * @return Timeline
     */
    public function recallTimeline(Context $context = null)
    {
        $log = $this->readLog($context);
        $logEvents = $this->parseLog($log);

        return $this->createTimeline($logEvents);
    }

    private function openWorkingCopy()
    {
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
            $result = @mkdir($dir, 0755, true);

            if ($result === false) {
                throw new \RuntimeException(sprintf('Unable to create directory %s', $dir));
            }
        }

        $file = sprintf('%s/%s/%s.json', $this->dataDir, $entry->getContext(), $entry->getIdentifier());
        $result = file_put_contents($file, json_encode($entry->getData()));

        if ($result === false) {
            throw new \RuntimeException(sprintf('Unable to write file %s', $file));
        }
    }

    /**
     * @param Entry $entry
     * @param User $user
     */
    private function commitFile(Entry $entry, User $user)
    {
        if ($this->gitWrapper->hasChanges()) {
            $this->gitWrapper->setUser($user->getName(), $user->getEmail());
            $this->gitWrapper->add(sprintf('%s/%s.json', $entry->getContext(), $entry->getIdentifier()));
            $this->gitWrapper->commit("What do you want, Mr. Quaid?");
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
     * @param string $version
     */
    private function checkoutVersion($version)
    {
        if (!$version) {
            $version = 'HEAD';
        }

        $this->gitWrapper->checkout($version);
    }

    /**
     * @param Context|null $context
     * @return string
     */
    private function readLog(Context $context = null)
    {
        $this->gitWrapper->log('--name-status');

        return $this->gitWrapper->getOutput();
    }

    /**
     * @param string $log
     * @return array
     */
    private function parseLog($log)
    {
        $events = array();

        foreach (preg_split('/(?:^|\n)commit /', $log, -1, PREG_SPLIT_NO_EMPTY) as $event) {
            preg_match('/^(.+?)\n/', $event, $m);
            $commit = $m[1];

            preg_match('/Date: +(.+?)\n/', $event, $m);
            $date = $m[1];

            preg_match('/Author: +(.+?) <(.+?)>/', $event, $m);
            $name = $m[1];
            $email = $m[2];

            preg_match('/\n\n +(.+?)\n\n/', $event, $m);
            $message = $m[1];

            preg_match('/\n([AMD])\t(.+?)\n/', $event, $m);

            $action = $m[1];
            $file = $m[2];

            $events[] = array(
                'commit' => $commit,
                'date' => $date,
                'user_name' => $name,
                'user_email' => $email,
                'message' => $message,
                'action' => $action,
                'file' => $file
            );
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

            $context = new Context($m[1]);
            $identifier = new Identifier($m[2]);

            $date = new \DateTime($logEvent['date']);

            $user = new User($logEvent['user_name'], $logEvent['user_email']);

            $events[] = new Event(
                $logEvent['commit'],
                $logEvent['message'],
                $user,
                $date->getTimestamp(),
                $context,
                $identifier
            );
        }

        return new Timeline($events);
    }
}
