<?php

namespace Wecamp\Recall\Core;

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
    public function addEntity(Entry $entry, User $user)
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
    public function getEntity(Context $context, Identifier $identifier, $version = null)
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
        // TODO: Implement recallTimeline() method.
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
        $result = mkdir($dir, 0755, true);

        if ($result === false) {
            throw new \RuntimeException(sprintf('Unable to create directory %s', $dir));
        }

        $file = sprintf('%s/%s/%s.json', $this->dataDir, $entry->getContext(), $entry->getIdentifier());
        $result = file_put_contents($file, json_encode($entry));

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
        $this->gitWrapper->setUser($user->getName(), $user->getEmail());

        $this->gitWrapper->add(sprintf('%s/%s.json', $entry->getContext(), $entry->getIdentifier()));
        $this->gitWrapper->commit();
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
        $rawData = file_get_contents($file);

        if ($rawData === false) {
            throw new \RuntimeException(sprintf('Unable to read file %s', $file));
        }

        return new Entry($context, $identifier, $rawData);
    }

    /**
     * @param string $version
     */
    private function checkoutVersion($version)
    {
        // TODO: Implement this!
    }
}
