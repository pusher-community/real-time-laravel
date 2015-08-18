# Debugging your server-side integration with Pusher

<div class="alert alert-warning">
  For the moment this section only covers debugging your integration via the Laravel Pusher Bridge.
</div>

The Pusher PHP library provides an abstraction upon the underlying HTTP requests that are made to Pusher in order to do things like trigger events. Sometimes things go wrong or we make mistakes. So it can be really handy to be able to know what's going on "under the hood" within the Pusher PHP library.

This section provides a way of logging the Pusher library debug output to the Laravel logs. There may be a better way of doing this, so please speak to the instructor or [submit a pull request](https://github.com/pusher-community/real-time-laravel) if you have any ideas. Hopefully things will become a bit easier in the future.

## Adding Pusher Logging via the AppServiceProvider

<i class="fa fa-rocket fa-2"></i> Open up `app/Providers/AppServiceProvider.php` and update it to look as follows:

```php
use Illuminate\Support\Facades\Log;

class LaravelLoggerProxy {
    public function log( $msg ) {
        Log::info($msg);
    }
}

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $pusher = $this->app->make('pusher');
        $pusher->set_logger( new LaravelLoggerProxy() );
    }
    
    ...
```

In the code above we're using the `Log` facade, creating a `LaravelLoggerProxy` that uses the facade and setting an instance of this class as the logger within the `AppServiceProvider-boot` function.

<i class="fa fa-rocket fa-2"></i> Open up `storage/logs/laravel.log`, delete the contents and save the file. Then load `http://localhost:8000/bridge` in a browser tab. Take a look at the `laravel.log` file now (depending no your editor you may need to re-open the file). It will now contain logging similar to the following:

```
[2015-08-17 12:45:13] local.INFO: Pusher: ->trigger received string channel "test-channel". Converting to array.  
[2015-08-17 12:45:13] local.INFO: Pusher: curl_init( http://api.pusherapp.com:80/apps/134576/events?auth_key=b1273751cc6d9854c1dd&auth_signature=9e90b0d73fcc1c456dd8fec43b2b50f9208581a0962a3a0eb4a318afa26be4ad&auth_timestamp=1439815513&auth_version=1.0&body_md5=e97f1648a58b2628efed547758fb8ddf )  
[2015-08-17 12:45:13] local.INFO: Pusher: trigger POST: {"name":"test-event","data":"{\"text\":\"Preparing the Pusher Laracon.eu workshop!\"}","channels":["test-channel"]}  
[2015-08-17 12:45:13] local.INFO: Pusher: exec_curl response: Array
(
    [body] => {}
    [status] => 200
)
```

This logging shows us the interaction that took place with the Pusher HTTP API and the response.

## Where next?

Now that you've set up your logging and you know how to view the log output we're ready to move to the client and look at [integrating the Pusher JS library](./pusher-js-integration.md).
