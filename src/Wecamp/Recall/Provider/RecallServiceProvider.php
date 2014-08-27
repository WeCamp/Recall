<?php

namespace Wecamp\Recall\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class RecallServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['recall.class'] = 'Wecamp\Recall\Core\GitRecall';
        $app['recall.data_dir'] = '';

        $app['recall'] = $app->share(
            function ($app) {
                $class = $app['recall.class'];

                $wrapper = new $class(
                    $app['recall_git_wrapper'],
                    $app['recall.data_dir']
                );

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
