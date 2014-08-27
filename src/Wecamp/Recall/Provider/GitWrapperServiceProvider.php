<?php

namespace Wecamp\Recall\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class GitWrapperServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['recall_git_wrapper.class'] = 'Wecamp\Recall\Git\GitWrapper';

        $app['recall_git_wrapper'] = $app->share(
            function ($app) {
                $class = $app['recall_git_wrapper.class'];

                $wrapper = new $class($app['git_wrapper']);

                return $wrapper;
            }
        );

        $app['git_wrapper.class'] = 'GitWrapper\GitWrapper';
        $app['git_wrapper.bin'] = null;
        $app['git_wrapper.home'] = null;

        $app['git_wrapper'] = $app->share(
            function ($app) {
                $class = $app['git_wrapper.class'];

                $wrapper = new $class($app['git_wrapper.bin']);

                if ($app['git_wrapper.home']) {
                    $wrapper->setEnvVar('HOME', $app['git_wrapper.home']);
                }

                return $wrapper;
            }
        );
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}
