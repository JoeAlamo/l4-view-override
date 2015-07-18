<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 18/07/2015
 * Time: 19:39
 */

namespace app\Extensions\ViewOverride;


use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider;

class ViewOverrideServiceProvider extends ViewServiceProvider {

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bindShared('view.finder', function($app)
        {
            $paths = $app['config']['view.paths'];
            if (\Session::has('override')) {
                $customFolder = \Session::get('override');
                array_unshift($paths, "$paths[0]/../viewoverrides/$customFolder");
            }

            return new FileViewFinder($app['files'], $paths);
        });
    }

} 