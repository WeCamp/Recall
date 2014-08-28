<?php

namespace Wecamp\Recall\Git;

use GitWrapper\GitWorkingCopy;
use \Mockery as m;

class GitWrapperTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown() {
        m::close();
    }

    public function testCallPassesTheMethod()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $gitWrapper->shouldReceive('init')->times(1)->with('test')->andReturn(true);

        $recallGitWrapper = new GitWrapper($gitWrapper);

        $returnValue = $recallGitWrapper->init('test');
        $this->assertTrue($returnValue);
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Unknown method arnold()
     */
    public function testCallWithBadMethod()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $recallGitWrapper = new GitWrapper($gitWrapper);

        $recallGitWrapper->arnold();
    }

    public function testCallReturnsGitWorkingCopyInstance()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $gitWorkingCopy = new GitWorkingCopy($gitWrapper, 'data');
        $gitWrapper->shouldReceive('init')->times(1)->andReturn($gitWorkingCopy);

        $recallGitWrapper = new GitWrapper($gitWrapper);

        $returnValue = $recallGitWrapper->init(false);
        $this->assertSame($recallGitWrapper, $returnValue);
    }

    public function testCallReturnsGitWrapperInstance()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $gitWrapper->shouldReceive('init')->times(1)->andReturn($gitWrapper);

        $recallGitWrapper = new GitWrapper($gitWrapper);

        $returnValue = $recallGitWrapper->init(false);
        $this->assertSame($recallGitWrapper, $returnValue);
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Unknown method add()
     */
    public function testCallWithYetUndefinedMethod()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $recallGitWrapper = new GitWrapper($gitWrapper);

        $recallGitWrapper->add(false);
    }

    public function testCallWithDefinedMethodAfterGitWorkingCopyReturned()
    {
        $gitWrapper = m::mock('GitWrapper\GitWrapper');
        $gitWorkingCopy = m::mock('GitWrapper\GitWorkingCopy');
        $gitWorkingCopy->shouldReceive('config')->times(2);
        $gitWrapper->shouldReceive('init')->times(1)->andReturn($gitWorkingCopy);
        $gitWorkingCopy->shouldReceive('add')->times(1)->andReturn($gitWrapper);

        $recallGitWrapper = new GitWrapper($gitWrapper);
        $recallGitWrapper->init(false);

        $recallGitWrapper->setUser('Douglas', 'douglas@rekall.com');

        $returnValue = $recallGitWrapper->add(false);

        $this->assertSame($recallGitWrapper, $returnValue);
    }
}
