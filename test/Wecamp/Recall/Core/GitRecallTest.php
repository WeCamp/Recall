<?php

namespace Wecamp\Recall\Core;

use Mockery;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use Wecamp\Recall\Fixture\Personal\Profile;

class GitRecallTest extends \PHPUnit_Framework_TestCase
{
    private $profile;

    private $wrapper;
    private $context;
    private $identifier;
    private $entry;
    private $user;

    protected function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('repo'));

        $this->profile = new Profile();

        $this->wrapper = Mockery::mock('Wecamp\Recall\Git\GitWrapper');

        $this->context = Mockery::mock('Wecamp\Recall\Core\Context');
        $this->context->shouldReceive('__toString')->andReturn('some/context');

        $this->identifier = Mockery::mock('Wecamp\Recall\Core\Identifier');
        $this->identifier->shouldReceive('__toString')->andReturn((string)$this->profile->getIdentifier());

        $this->entry = Mockery::mock('Wecamp\Recall\Core\Entry');
        $this->entry->shouldReceive('getContext')->andReturn($this->context);
        $this->entry->shouldReceive('getIdentifier')->andReturn($this->identifier);
        $this->entry->shouldReceive('getData')->andReturn($this->profile->getData());

        $this->user = Mockery::mock('Wecamp\Recall\Core\User');
        $this->user->shouldReceive('getName')->andReturn('Douglas Quaid');
        $this->user->shouldReceive('getEmail')->andReturn('douglas@quaid.com');
    }

    protected function tearDown()
    {
        Mockery::close();
    }

    public function testAddingAnEntry()
    {
        $this->wrapper->shouldReceive('workingCopy')->times(1)->with(vfsStream::url('repo'));
        $this->wrapper->shouldReceive('setUser')->times(1)->with('Douglas Quaid', 'douglas@quaid.com');
        $this->wrapper->shouldReceive('add')->times(1)->with('some/context/profile.json');
        $this->wrapper->shouldReceive('checkout')->times(1)->with('HEAD');
        $this->wrapper->shouldReceive('hasChanges')->times(1)->andReturn(true);
        $this->wrapper->shouldReceive('commit')->times(1)->with('Start the reactor. Free Mars...');

        $recall = new GitRecall($this->wrapper, vfsStream::url('repo'));

        $recall->addEntry($this->entry, $this->user, "Test adding an entry");

        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('some/context/profile.json'));
    }

    public function testGettingAnEntry()
    {
        $this->wrapper->shouldReceive('workingCopy')->times(1)->with(vfsStream::url('repo'));
        $this->wrapper->shouldReceive('checkout')->times(1)->with('HEAD');

        $file = vfsStream::newFile('some/context/profile.json');
        $file->setContent($this->profile->getData()->serialize());
        vfsStreamWrapper::getRoot()->addChild($file);

        $recall = new GitRecall($this->wrapper, vfsStream::url('repo'));

        $entry = $recall->getEntry($this->context, $this->identifier);

        $this->assertEquals('some/context', (string)$entry->getContext());
        $this->assertEquals((string)$this->profile->getIdentifier(), (string)$entry->getIdentifier());
        $this->assertEquals($this->profile->getData()->serialize(), $entry->getData()->serialize());
    }

    public function testRecallingTheTimeline()
    {
        $log = <<< EOT
commit b93a19769533ed73544f6c739d1040bcbd7f032f
Author: Douglas Quaid <douglas@quaid.com>
Date:   Wed Aug 27 13:06:09 2014 +0200

    What do you want, Mr. Quaid?

A       some/context/profile.json
EOT;

        $this->wrapper->shouldReceive('workingCopy')->times(1)->with(vfsStream::url('repo'));
        $this->wrapper->shouldReceive('log')->times(1)->with('--name-status');
        $this->wrapper->shouldReceive('getOutput')->times(1)->andReturn($log);

        $recall = new GitRecall($this->wrapper, vfsStream::url('repo'));

        $timeline = $recall->recallTimeline($this->context);
        $event = $timeline[0];

        $this->assertCount(1, $timeline);

        $this->assertInstanceOf('Wecamp\Recall\Core\Event', $event);
        $this->assertEquals('b93a19769533ed73544f6c739d1040bcbd7f032f', $event->getEventIdentifier());
        $this->assertEquals('1409137569', $event->getTimestamp());
        $this->assertEquals('Douglas Quaid', $event->getUser()->getName());
        $this->assertEquals('douglas@quaid.com', $event->getUser()->getEmail());
        $this->assertEquals('What do you want, Mr. Quaid?', $event->getDescription());
        $this->assertEquals('some/context', (string)$event->getEntryContext());
        $this->assertEquals('profile', (string)$event->getEntryIdentifier());
    }
}
