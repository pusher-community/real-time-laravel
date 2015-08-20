# Add the Pusher credentials to `.env`

When the Laravel application was created a `.env` file will also have been created in the root of the app.

<i class="fa fa-rocket fa-2"></i> Take the Pusher credentials we noted down earlier (`app_id`, `key` and `secret`) - or you may even have a browser tap still open on the *App Keys* section of your app in the Pusher dashboard - and add them to the `.env` file:

```php
PUSHER_APP_ID=YOUR_APP_ID
PUSHER_KEY=YOUR_APP_KEY
PUSHER_SECRET=YOUR_APP_SECRET
```

Now to integrate the Pusher PHP library. To do this you have a couple of options. The first is to use a Laravel Pusher Bridge and add a [service provider](http://laravel.com/docs/5.1/providers). The second is to make use of Laravel [events](http://laravel.com/docs/5.1/events) and use a Pusher event broadcaster.

## Where next?

There are two options for integrating Pusher into your Laravel back-end. The first is using  a [Laravel Pusher Bridge](./laravel-pusher-bridge.md) and the second is via Laravel's [Event Broadcasting](./event-broadcaster.md). Let's start with the bridge option.
