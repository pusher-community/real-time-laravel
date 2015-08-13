# Integrate Pusher

The first thing we need to do is configure the environment variables with your Pusher application credentials.

## Add the Pusher credentials to `.env`

When the application was created a `.env` file will also have been created in the root of the app.

Take the Pusher credentials we noted down earlier (`app_id`, `key` and `secret`) - or you may even have a browser tap still open on the Main app in the Pusher dashboard - and add them to the `.env` file:

```php
PUSHER_APP_ID = 'YOUR_APP_ID'
PUSHER_KEY = 'YOUR_APP_KEY'
PUSHER_SECRET = 'YOUR_APP_SECRET'
```

Now to integrate the Pusher PHP library. To do this you have a couple of options. The first is to use a Laravel Pusher wrapper and add a [service provider](http://laravel.com/docs/5.1/providers). The second is to make use of Laravel [events](http://laravel.com/docs/5.1/events) and use a Pusher event broadcaster.

## Using a Laravel Pusher wrapper

There are a few Laravel wrappers for the Pusher PHP library that allow you to integrate with Pusher. The most popular wrapper we know of is [vinkla/pusher](https://github.com/vinkla/pusher) by [Vincent Klaiber](https://github.com/vinkla).

Let's start by installing the package:

```
composer install vinkla/pusher
php artisan vendor:publish
```

Then setting up the the vinkla/pusher vendor configuration in `config/pusher.php` to use the environment variables:

```php
'connections' => [

    'main' => [
        'auth_key' => env('PUSHER_KEY'),
        'secret' => env('PUSHER_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        ...
    ],
```

Next let's add the vinkla/pusher package service provider to the `providers` array in `config/app.php`:

```php
Vinkla\Pusher\PusherServiceProvider::class,
```

Once that's set up we can get access to a `Pusher` instance directly using the [Service Container](http://laravel.com/docs/5.1/container) or indirectly via [Dependency Injection](http://laravel.com/docs/5.1/controllers#dependency-injection-and-controllers).

To quickly test this, open `app/Http/routes.php` and replace the contents with:

```php
<?php

use Illuminate\Support\Facades\App;

get('/', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
                      'test-event', 
                      array('text' => 'Preparing the Pusher Laracon.eu workshop!'));
});
```

We'll cover the details of this in the [trigger event section](./trigger-event.md).

Next we want to test that this is working. To do this:

1. Open up the Pusher Debug Console for your Pusher application
2. Run your Laravel application using `php artisan serve`
3. In a new browser tab or window navigate to the route we've just defined in the Laravel app, `http://localhost:8000/`

You'll now see the event appear in the Pusher Debug Console. It's working!

<div class="alert alert-warning">
  <strong>It's not working!</strong> Oh no, Something has gone wrong. Don't worry, we'll work out what's happening in an upcoming section on <strong>Debugging your server-side integration with Pusher</strong>.
</div>

## Using Laravel Event Broadcasting

By using Laravel 5.1 you already have the Pusher library integrated into your application so there's no installation required. We've already done all the set up we need when we set our environment variables.

<div class="alert alert-info">
  The Pusher Event Broadcaster is configured in <code>config/broadcasting.php</code>. Luckily it's the default broadcaster so we don't actually need to configure anything.
</div>

Laravel 5.1 comes with an in-built Pusher Event Broadcaster that we're going to use. To use this we need to follow a few conventions. Firstly, we need to define a class that represents our event. For simplicity we'll add his directly to `app/Http/routes.php` for now.

```php
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function broadcastOn()
    {
        return ['test-channel'];
    }
}
```

As with the previous example, we'll go in to the details of this in the [trigger event section](./trigger-event.md).

Next, update the contents of the `app/Http/routes.php` file with the following:

```php
get('/', function() {
    event(new TestEvent('Broadcasting in Laravel using Pusher!'));
});
```

As before, to test:

1. Open up the Pusher Debug Console for your Pusher application
2. Ensure your Laravel application is running (`php artisan serve`)
3. In a new browser tab or window, navigate to the `/` route in the Laravel app (or simply refresh your tab), `http://localhost:8000/`.

Again, you'll see the event appear in the Pusher Debug Console. It's working!

<div class="alert alert-warning">
  <strong>It's not working!</strong> Oh no, Something has gone wrong. Don't worry, we'll work out what's happening in an upcoming section on <strong>Debugging your server-side integration with Pusher</strong>.
</div>

## Wrapper v Event Broadcasting

By using the wrapper instead of Event Broadcasting you don't need to adhere to some of the Event Broadcasting rules and it provides consistency when it comes to accessing the `Pusher` instance for other pieces of Pusher functionality such as [authenticating channel subscriptions](#), [querying application state](#) (such as channels that have active subscriptions) and validating incoming [Pusher WebHooks](https://pusher.com/docs/webhooks).

However, by using using event broadcasting you are completely decoupling your back-end functionality from having any reliance on Pusher's broadcast messaging which means you can quickly switch out the message broadcasting service that you're using.

Make the best choice for your app.

## Where next?

Now that we've covered the options for integrating the Pusher PHP library into your Laravel back-end let's dig into [triggering events](./trigger-event.md) in more detail.
