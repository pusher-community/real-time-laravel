# Using a Laravel Pusher Bridge

There are a few Laravel bridges/wrappers for the Pusher PHP library that allow you to integrate with Pusher. The most popular bridge we know of is [vinkla/pusher](https://github.com/vinkla/pusher) by [Vincent Klaiber](https://github.com/vinkla).

<i class="fa fa-rocket fa-2"></i> Let's start by installing the package:

```
› composer require vinkla/pusher
```

<i class="fa fa-rocket fa-2"></i> Next let's add the vinkla/pusher package service provider to the `providers` array in `config/app.php`:

```php
Vinkla\Pusher\PusherServiceProvider::class,
```

And then publish so the Pusher configuration file is copied to the `config` directory:

```
› php artisan vendor:publish
```

<i class="fa fa-rocket fa-2"></i> Then set up the the vinkla/pusher vendor configuration in `config/pusher.php` to use the environment variables. Update the `auth_key`, `secret` and `app_id` values of the `main` connection as follows:

```php
'connections' => [

    'main' => [
        'auth_key' => env('PUSHER_KEY'),
        'secret' => env('PUSHER_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [],
        'host' => null,
        'port' => null,
        'timeout' => null,
    ],
```

<div class="alert alert-warning">
  <strong><code>config/pusher.php</code> Gotcha!</strong>
  <p>
  Make sure you've updated <code>config/pusher.php</code> and <strong>not</strong> <code>vendor/vinkla/pusher/config/pusher.php</code>.
  </p>
</div>

Once that's set up we can get access to a `Pusher` instance directly using the [Service Container](http://laravel.com/docs/5.1/container) or indirectly via [Dependency Injection](http://laravel.com/docs/5.1/controllers#dependency-injection-and-controllers).

<i class="fa fa-rocket fa-2"></i> To quickly test this, open `app/Http/routes.php` and add:

```php
use Illuminate\Support\Facades\App;

get('/bridge', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
                      'test-event', 
                      array('text' => 'Preparing the Pusher Laracon.eu workshop!'));
                      
    return view('welcome');
});
```

We'll cover the details of this in a later exercise.

<i class="fa fa-rocket fa-2"></i> Next we want to test that this is working. To do this:

1. Open up the Pusher Debug Console for your Pusher application
2. Run your Laravel application using `php artisan serve` (if it's not already running)
3. In a new browser tab or window navigate to the route we've just defined in the Laravel app, http://localhost:8000/bridge

You'll now see the event appear in the Pusher Debug Console. It's working!

<div class="alert alert-warning">
  <strong>It's not working!</strong> Oh no, Something has gone wrong. Don't worry, we'll work out what's happening in an upcoming section on <a href="./server-debugging.md">Debugging your server-side integration with Pusher</a>.
</div>

## Where next?

Next, let's see how the same thing can be achieved using the [Laravel Event Broadcaster](./event-broadcaster.md).
