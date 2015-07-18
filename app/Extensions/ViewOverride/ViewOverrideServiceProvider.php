<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 18/07/2015
 * Time: 19:39
 */

namespace app\Extensions\ViewOverride;


use Illuminate\View\ViewServiceProvider;

class ViewOverrideServiceProvider extends ViewServiceProvider {

    public function registerFactory()
    {
        $this->app->bindShared('view', function($app)
        {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $env = new Factory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

            return $env;
        });
    }

} 