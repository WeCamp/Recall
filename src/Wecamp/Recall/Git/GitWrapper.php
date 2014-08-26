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
     * @var string
     */
    private $userName = '';

    /**
     * @var string
     */
    private $userEmail = '';

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
        $this->userName = $name;
        $this->userEmail = $email;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, array $arguments)
    {
        if (!isset($this->map[$method])) {
            throw new \BadMethodCallException(sprintf('Unknown method %s()', $method));
        }

        $returnValue = call_user_func_array(array($this->map[$method], $method), $arguments);

        if ($returnValue instanceof GitWorkingCopy) {
            $this->defineWorkingCopyInMap($returnValue);
        }

        return $returnValue;
    }

    /**
     * @param \GitWrapper\GitWrapper $wrapper
     */
    private function defineWrapperInMap(\GitWrapper\GitWrapper $wrapper)
    {
        $this->wrapperMap = array(
            'getDispatcher' => $wrapper,
            'setDispatcher' => $wrapper,
            'setGitBinary' => $wrapper,
            'getGitBinary' => $wrapper,
            'setEnvVar' => $wrapper,
            'unsetEnvVar' => $wrapper,
            'getEnvVar' => $wrapper,
            'getEnvVars' => $wrapper,
            'setTimeout' => $wrapper,
            'getTimeout' => $wrapper,
            'setProcOptions' => $wrapper,
            'getProcOptions' => $wrapper,
            'setPrivateKey' => $wrapper,
            'unsetPrivateKey' => $wrapper,
            'addOutputListener' => $wrapper,
            'addLoggerListener' => $wrapper,
            'removeOutputListener' => $wrapper,
            'streamOutput' => $wrapper,
            'version' => $wrapper,
            'git' => $wrapper,
            'run' => $wrapper
        );
    }

    /**
     * @param GitWorkingCopy $workingCopy
     */
    private function defineWorkingCopyInMap(GitWorkingCopy $workingCopy)
    {
        $workingCopy->config('user.name', $this->userName);
        $workingCopy->config('user.email', $this->userEmail);

        $this->wrapperMap = array(
            'workingCopy' => $workingCopy,
            'init' => $workingCopy,
            'cloneRepository' => $workingCopy
        );
    }
}
