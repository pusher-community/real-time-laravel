# Triggering a Notification Event

Let's start by creating a `NotificationController` with two actions:

1. `getIndex` to show a view that lets a user send a notification
2. `postNotify` to handle a notification request and trigger the notification event

<i class="fa fa-rocket fa-2"></i> Download the [NotificationController.php template](../assets/laravel_app/NotificationController.php) to `app/Http/Controllers/NotificationController.php`

<i class="fa fa-rocket fa-2"></i> Open `app/Http/Controllers/NotificationController.php` it contains two routes:

1. `getIndex` to serve a notifications view
2. `postNotify` to handle notification `POST` requests

<i class="fa fa-rocket fa-2"></i> Next, ensure the new controller is listed in `app/Http/routes.php`:

```php
Route::controller('notifications', 'NotificationController');
```

<i class="fa fa-rocket fa-2"></i> Navigate to `http://localhost:8000/notifications` and you should see a `View [notification] not found` error. That's fine since we haven't created our view file yet.

## Create a view

For our simple app notifications will be manually triggered. To do this we need a user interface that lets a user:

* Enter some text to be shown in a notification
* Submit a form indicating the notification should be triggered

<i class="fa fa-rocket fa-2"></i> Download the [notification.blade.php template](../assets/laravel_app/notification.blade.php) to `resources/views/notification.blade.php`. It contains a number of `<script>` and CSS references including the Pusher JavaScript library and jQuery from a CDN, as well as a basic HTML structure for our notifications demo.

<i class="fa fa-rocket fa-2"></i> Next, take a look at the `<form id="notify_form">` in the HTML. It will be used to capture the user input and eventually make a `POST` AJAX request to our `notifications/notify` route.

## Submit the Notification Text

<i class="fa fa-rocket fa-2"></i> Let's take a look at the JavaScript code within the `<script>` tag at the end of the `</body>`. As per the code comments this sets things up so that the `form` submission is handled by JavaScript and makes a `POST` to the server with the notification text. 

<i class="fa fa-rocket fa-2"></i> Open http://localhost:8000/notifications, enter some text and hit *enter* to submit the form. You should see `notification submitted` logged to the browser console.

## Trigger the Event via Pusher

In the `postNotify` function of our `NotificationController` we want to get the submitted text, do some basic sanitisation and trigger the event via Pusher.

<i class="fa fa-rocket fa-2"></i> Over to you to complete the `TODO` items below (see [Laravel Pusher Bridge](../getting-started/laravel-pusher-bridge.html) for some code examples).

```php
public function postNotify(Request $request)
{
  $notifyText = e($request->input('notify_text'));

  // TODO: Get Pusher instance from service container

  // TODO: The notification event data should have a property named 'text'
  
  // TODO: On the 'notifications' channel trigger a 'new-notification' event
  
}
```

Remember that you can use the Pusher Debug Console to make sure that events are reaching Pusher. If you don't see the events there you can always look at the Laravel logs in `storage/logs/laravel.log` (see [server debugging](server-debugging.html)).

## Where next?

Once you can see the event reaching the Pusher Debug Console we're good to start [adding the notifications UI](./ui.md).
