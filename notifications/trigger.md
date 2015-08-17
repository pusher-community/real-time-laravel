# Triggering a Notification Event

Let's start by creating a `NotificationController` with two actions `getIndex` to show a view that lets a user send a notification and `postNotify` to handle a notification request and trigger the notification event.

Create an empty controller with the following command:

```
› php artisan make:controller NotificationController --plain
```

Open up the newly created `app/Http/Controllers/NotificationController.php` and add `getIndex` and `postNotify` actions as follows:

```php
class NotificationController extends Controller
{
    public function getIndex()
    {
      return view('notification');
    }

    public function postNotify(Request $request)
    {
    }
}
```

And ensure the new controller is listed in `app/Http/routes.php`:

```php
Route::controller('notifications', 'NotificationController');
```

Navigate to `http://localhost:8000/notifications` and you should see a `View [notification] not found` error. That's fine since we haven't created our view file yet.

## Create a view

For our simple app notifications will be manually triggered. To do this we need a user interface that lets a user:

* Enter some text to be shown in a notification
* Submit a form indicating the notification should be triggered

Create `resources/views/notification.blade.php` and copy & paste the contents of [SOME template URL](#) into it. It contains a script include of jQuery from a CDN, a CSS include and a basic HTML structure.

Next, add the following `<form>` to the HTML.

```html
<form id="notify_form" action="/notifications/notify" method="post">
  <label for="notify_text">What's the notification?</label>
  <input type="text" id="notify_text" name="notify_text" minlength="3" required />
</form>
```

This form will be used to capture the user input and eventually make a `POST` AJAX request to our `notifications/notify` route.

## Submit the Notification Text

Let's add the AJAX code now.

```html
<script>
function notifyInit() {
  // set up form submission handling
  $('#notify_form').submit(notifySubmit);
}

// Handle the form submission
function notifySubmit() {
  var notifyText = $('#notify_text').val();
  if(notifyText.length < 3) {
    return;
  }

  // Build POST data and make AJAX request
  var data = {notify_text: notifyText};
  $.post('/notifications/notify', data).success(notifySuccess);

  // Ensure the normal browser event doesn't take place
  return false;
}

// Handle the success callback
function notifySuccess() {
  console.log('notification submitted');
}

$(notifyInit);
</script>
```

As per the code comments this sets things up so that the `form` submission is handled by JavaScript and makes a `POST` to the server with the notification text. Open http://localhost:8000/notifications, enter some text and hit *enter* to submit the form. You should see `notification submitted` logged to the browser console.

## Trigger the Event via Pusher

In the `postNotify` function of our `NotificationController` we want to get the submitted text, do some basic sanitisation and trigger the event via Pusher.

Over to you to complete the `TODO` items below. You'll also need to import `Illuminate\Support\Facades\App` in order to use the `App` facade to get the `Pusher` instance from the service container

```php
public function postNotify(Request $request)
{
  $notifyText = e($request->input('notify_text'));

  // TODO: Get Pusher instance from service container

  // TODO: Trigger `new-notification` event on `notifications` channel
}
```

Remember that you can use the Pusher Debug Console to make sure that events are reaching Pusher. If you don't see the events there you can always look at the Laravel logs in `storage/logs/laravel.log`.

## Where next?

Once you can see the event reaching the Pusher Debug Console we're good to start [adding the notifications UI](./ui.md).
