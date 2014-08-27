<?php

namespace Wecamp\Recall\Git;

use GitWrapper\GitWorkingCopy;

class GitWrapper
{
    /**
     * @var array
     */
    private $map = array();

    /**
     * @var GitWorkingCopy
     */
    private $workingCopy;

    /**
     * @var bool
     */
    private $isUserSetOnWorkingCopy = false;

    /**
     * @param \GitWrapper\GitWrapper $wrapper
     */
    public function __construct(\GitWrapper\GitWrapper $wrapper)
    {
        $this->defineWrapperInMap($wrapper);
    }

    /**
     * @param string $name
     * @param string $email
     */
    public function setUser($name, $email)
    {
        $this->setUserOnWorkingCopy($name, $email);
        $this->isUserSetOnWorkingCopy = true;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     * @throws \RuntimeException
     */
    public function __call($method, array $arguments)
    {
        if (!isset($this->map[$method])) {
            throw new \BadMethodCallException(sprintf('Unknown method %s()', $method));
        }

        if ($this->map[$method] instanceof GitWorkingCopy && !$this->isUserSetOnWorkingCopy) {
            throw new \RuntimeException('User not set on working copy yet');
        }

        if ($arguments) {
            $returnValue = call_user_func_array(array($this->map[$method], $method), $arguments);
        } else {
            $returnValue = call_user_func(array($this->map[$method], $method));
        }

        if ($returnValue instanceof GitWorkingCopy) {
            $this->storeWorkingCopy($returnValue);
            $this->defineWorkingCopyInMap($returnValue);
            return $this;
        }

        if ($returnValue instanceof \GitWrapper\GitWrapper) {
            return $this;
        }

        return $returnValue;
    }

    /**
     * @param \GitWrapper\GitWrapper $wrapper
     */
    private function defineWrapperInMap(\GitWrapper\GitWrapper $wrapper)
    {
        $this->map['addLoggerListener'] = $wrapper;
        $this->map['addOutputListener'] = $wrapper;
        $this->map['cloneRepository'] = $wrapper;
        $this->map['getDispatcher'] = $wrapper;
        $this->map['getEnvVar'] = $wrapper;
        $this->map['getEnvVars'] = $wrapper;
        $this->map['getGitBinary'] = $wrapper;
        $this->map['getProcOptions'] = $wrapper;
        $this->map['getTimeout'] = $wrapper;
        $this->map['git'] = $wrapper;
        $this->map['init'] = $wrapper;
        $this->map['removeOutputListener'] = $wrapper;
        $this->map['run'] = $wrapper;
        $this->map['setDispatcher'] = $wrapper;
        $this->map['setEnvVar'] = $wrapper;
        $this->map['setGitBinary'] = $wrapper;
        $this->map['setPrivateKey'] = $wrapper;
        $this->map['setProcOptions'] = $wrapper;
        $this->map['setTimeout'] = $wrapper;
        $this->map['streamOutput'] = $wrapper;
        $this->map['unsetEnvVar'] = $wrapper;
        $this->map['unsetPrivateKey'] = $wrapper;
        $this->map['version'] = $wrapper;
        $this->map['workingCopy'] = $wrapper;
    }

    /**
     * @param GitWorkingCopy $workingCopy
     */
    private function defineWorkingCopyInMap(GitWorkingCopy $workingCopy)
    {
        $this->map['add'] = $workingCopy;
        $this->map['apply'] = $workingCopy;
        $this->map['bisect'] = $workingCopy;
        $this->map['branch'] = $workingCopy;
        $this->map['checkout'] = $workingCopy;
        $this->map['checkoutNewBranch'] = $workingCopy;
        $this->map['clean'] = $workingCopy;
        $this->map['clearOutput'] = $workingCopy;
        $this->map['commit'] = $workingCopy;
        $this->map['config'] = $workingCopy;
        $this->map['diff'] = $workingCopy;
        $this->map['fetch'] = $workingCopy;
        $this->map['fetchAll'] = $workingCopy;
        $this->map['getBranches'] = $workingCopy;
        $this->map['getDirectory'] = $workingCopy;
        $this->map['getOutput'] = $workingCopy;
        $this->map['getStatus'] = $workingCopy;
        $this->map['grep'] = $workingCopy;
        $this->map['hasChanges'] = $workingCopy;
        $this->map['isCloned'] = $workingCopy;
        $this->map['log'] = $workingCopy;
        $this->map['merge'] = $workingCopy;
        $this->map['mv'] = $workingCopy;
        $this->map['pull'] = $workingCopy;
        $this->map['push'] = $workingCopy;
        $this->map['pushTag'] = $workingCopy;
        $this->map['pushTags'] = $workingCopy;
        $this->map['rebase'] = $workingCopy;
        $this->map['remote'] = $workingCopy;
        $this->map['reset'] = $workingCopy;
        $this->map['rm'] = $workingCopy;
        $this->map['setCloned'] = $workingCopy;
        $this->map['show'] = $workingCopy;
        $this->map['status'] = $workingCopy;
        $this->map['tag'] = $workingCopy;
    }

    /**
     * @param GitWorkingCopy $workingCopy
     */
    private function storeWorkingCopy(GitWorkingCopy $workingCopy)
    {
        $this->workingCopy = $workingCopy;
    }

    /**
     * @param string $name
     * @param string $email
     * @throws \RuntimeException
     */
    private function setUserOnWorkingCopy($name, $email)
    {
        if (!$this->workingCopy) {
            throw new \RuntimeException('Working copy not opened yet');
        }

        $this->workingCopy->config('user.name', $name);
        $this->workingCopy->config('user.email', $email);
    }
}
