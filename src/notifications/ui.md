# Adding Notifications to the UI

We know that our back-end application is successfully triggering events. Now let's look at how we can receive those events within our client application. Pusher has WebSocket-powered client libraries for JavaScript, Android and iOS.

In this section we're going to use the Pusher JavaScript library to receive the notification from the server and use the [toastr](https://github.com/CodeSeven/toastr) library to show the notifications. 

We briefly looked at the Pusher JavaScript library previously, but let's start by looking at some of the conventions in a bit more detail.

## Channels & Events

We trigger events on channels from the back-end. On the front-end we [subscribe](https://pusher.com/docs/client_api_guide/client_public_channels#subscribe) to channels and bind to [events](https://pusher.com/docs/client_api_guide/client_events) on those channels. Whenever an event occurs on a channel we can define a `function` to be called to handle that event and any associated event data payload.

```js
var pusher = new Pusher('{{env("PUSHER_KEY")}}');
var channel = pusher.subscribe('channel-name');
channel.bind('event-name', function(data) {
  // do something with the event data
});
```

## Showing the Notifications

The Pusher JavaScript library and the toastr notification library have already been included in the [template](../assets/laravel_app/notifiation.blade.php) we copied earlier. So, all we need to do is subscribe to the `notifications` channel, bind to the `new-notification` event and use the toastr library to show the notification.

<i class="fa fa-rocket fa-2"></i> Use the following code outline to implement the notification functionality:

```js
$(notifyInit); // Existing functionality

// Use toastr to show the notification
function showNotification(data) {
    // TODO: get the text from the event data
    
    // TODO: use the text in the notification
    //toastr.success(text, null, {"positionClass": "toast-bottom-left"});
}

var pusher = new Pusher('{{env("PUSHER_KEY")}}');

// TODO: Subscribe to the channel

// TODO: Bind to the event and pass in the notification handler
```

<div class="alert alert-info">
  <p>You can test the notification functionality without a back-end in two ways:</p>
  <ol>
    <li>Since the <code>showNotification</code> function is global you can test it by opening up the browser console and calling it with <code>showNotification({text:"hello"});</code>.</li>
    <li>You can use the <a href="https://pusher.com/docs/debugging#event_creator">Event Creator</a> in the Pusher Debug Console to trigger events</li>
  </ol>
</div>

Once you've put those few pieces of code in place you've now got real-time notifications in your app. 

<i class="fa fa-rocket fa-2"></i> Open up a http://localhost:8000/notifications in a second browser window - even a different browser altogether - and test out the functionality.

<div class="alert alert-info">
  If you've got a tool like awesome <a href="https://ngrok.com/">ngrok</a> installed you can share the app with anybody else in the world to test out your new real-time functionality.
</div>

## Extras

If you get everything else done and you've still some time left. Why not try...

### Excluding the Triggerer

It's possible to stop the user who triggered the event also receiving the event by Pusher. To do this you need to pass a unique connection identifier called the `socket_id` to the `$pusher->trigger` function call.

<i class="fa fa-rocket fa-2"></i> You can get the `socket_id` on the client in JavaScript using `pusher.connection.socket_id` and pass it to the back-end `notifications/notify` endpoint in the `POST` data. Then you can use it to exclude that user from getting their own event using `$pusher->trigger($channelName, $eventName,  $eventData, $socketId)`.

## Where next?

Let's have a look a [what we've learned](./learned.md) in this chapter.
