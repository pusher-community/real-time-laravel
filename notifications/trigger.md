# Triggering a Notification Event

Let's start by creating a `NotificationController` with two actions `getIndex` to show a view that lets a user send a notification and `postNotify` to handle a notification request and trigger the notification event.

<i class="fa fa-rocket fa-2"></i> Create an empty controller with the following command:

```
› php artisan make:controller NotificationController --plain
```

<i class="fa fa-rocket fa-2"></i> Open up the newly created `app/Http/Controllers/NotificationController.php` and add `getIndex` and `postNotify` actions as follows:

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

<i class="fa fa-rocket fa-2"></i> And ensure the new controller is listed in `app/Http/routes.php`:

```php
Route::controller('notifications', 'NotificationController');
```

<i class="fa fa-rocket fa-2"></i> Navigate to `http://localhost:8000/notifications` and you should see a `View [notification] not found` error. That's fine since we haven't created our view file yet.

## Create a view

For our simple app notifications will be manually triggered. To do this we need a user interface that lets a user:

* Enter some text to be shown in a notification
* Submit a form indicating the notification should be triggered

<i class="fa fa-rocket fa-2"></i> Create `resources/views/notification.blade.php` and copy & paste the contents of this <a href="../assets/laravel_app/notification.blade.php" target="_blank">notification.blade.php template</a> into it (or simply copy over the file). It contains a number of `<script>` and CSS references including the Pusher JavaScript library and jQuery from a CDN, as well as a basic HTML structure for our notifications demo.

<i class="fa fa-rocket fa-2"></i> Next, take a look at the `<form id="notify_form">` in the HTML. It will be used to capture the user input and eventually make a `POST` AJAX request to our `notifications/notify` route.

## Submit the Notification Text

<i class="fa fa-rocket fa-2"></i> Let's add the AJAX code now. Towards the bottom of the template you'll find an empty `<script>` tag. Update it with the following content.

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

As per the code comments this sets things up so that the `form` submission is handled by JavaScript and makes a `POST` to the server with the notification text. 

<i class="fa fa-rocket fa-2"></i> Open http://localhost:8000/notifications, enter some text and hit *enter* to submit the form. You should see `notification submitted` logged to the browser console.

## Trigger the Event via Pusher

In the `postNotify` function of our `NotificationController` we want to get the submitted text, do some basic sanitisation and trigger the event via Pusher.

<i class="fa fa-rocket fa-2"></i> Over to you to complete the `TODO` items below. You'll also need to import `Illuminate\Support\Facades\App` in order to use the `App` facade to get the `Pusher` instance from the service container

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
