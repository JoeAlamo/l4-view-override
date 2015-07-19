# Laravel 4 View Override PoC
By extending Laravel's ViewServiceProvider with our [own](https://github.com/JoeAlamo/l4-view-override/blob/master/app/Extensions/ViewOverride/ViewOverrideServiceProvider.php) and making sure that our [ViewServiceProvider is autoloaded](https://github.com/JoeAlamo/l4-view-override/blob/master/app/config/app.php#L126) instead of the default, we can dynamically alter which paths View::make() looks at when attempting to find a view.

## View Folder Structure
In this example, default views go in the app/views folder and overridden views go in the app/viewoverrides/{NAMESPACE} folder. This is purely for demonstration purposes and can be customised. The hierarchy of the overridden view must be the same as the view it is wanting to override. For example, to override the app/views/emails/users/welcome.blade.php view you must create it at app/viewoverrides/{NAMESPACE}/emails/users/welcome.blade.php.

## Service Provider
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
                 if ($this->app->session->has('override')) {
                     $customFolder = $this->app->session->get('override');
                     array_unshift($paths, "$paths[0]/../viewoverrides/$customFolder");
                 }
                 return new FileViewFinder($app['files'], $paths);
             });
        }
    }

The only method that we override is the registerViewFinder() method, which gets called by ViewServiceProvider->register() during the early stages of the request lifecycle. For this example, based on the existence of a variable stored in the session we alter the array of paths that the FileViewFinder will interrogate. By using array_unshift and placing the custom path at the start of the array, we ensure that if an overridden view is found it will use that - otherwise it will fallback to the default view path set in app/config/view.php

We then return a new instance of Laravel's FileViewFinder - passing it our altered $paths array. If we wanted to, we could extend the FileViewFinder class and return our own class instead.

## Testing
To test out the PoC, clone the repo, run composer install and navigate to /test in your browser.
