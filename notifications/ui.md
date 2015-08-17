# Adding Notifications to the UI

We know that our back-end application is successfully triggering events. Now let's look at how we can receive those events within our client application. Pusher has WebSocket-powered (with fallback) client libraries for JavaScript, Android and iOS.

In this section we're going to use the Pusher JavaScript library to receive the notification from the server and use the [toastr](https://github.com/CodeSeven/toastr) library to show the notifications. 

We briefly looked at the Pusher JavaScript library previously, but let's start by looking at some of the conventions in a bit more detail.

## Channels & Events

We trigger events on channels from the back-end. On the front-end we **subscribe** to channels and bind to **events** on those channels. Whenever an event occurs on a channel we can define a `function` to be called to handle that event and any associated event data payload.

```js
var pusher = new Pusher('{{env("PUSHER_KEY")}}');
var channel = pusher.subscribe('channel-name');
channel.bind('event-name', function(data) {
  // do something with the event data
});
```

## Showing the Notifications

The Pusher JavaScript library and the toastr notification library has already been included in the [template](#) we copied earlier. So, all we need to do is subscribe to the `notifications` channel, bind to the `new-notification` event and use the toastr library to show the notification.

Use the following code outline to implement the notification functionality:

```js
  $(notifyInit);

  var pusher = new Pusher('{{env("PUSHER_KEY")}}');

  // Subscribe to the channel
  var channel = pusher.subscribe('notifications');

  // Bind to the event and pass in the notification handler
  channel.bind('new-notification', showNotification);
</script>
```

<div class="alert alert-info">
  <p>You can test the notification functionality without a back-end in two ways:</p>
  <ol>
    <li>Since the <code>showNotification</code> function is global you can test it by opening up the browser console and calling it with <code>showNotification({text:"hello"});</code>.</li>
    <li>You can use the <a href="https://pusher.com/docs/debugging#event_creator">Event Creator</a> in the Pusher Debug Console to trigger events</li>
  </ol>
</div>

Once you've put those few pieces of code in place you've not got real-time notifications in your app. Open up a http://localhost:8000/notifications in a second browser window - even a different browser altogether - and test out the functionality.

If you've got a tool like awesome [ngrok](https://ngrok.com/) installed you can share the app with anybody else in the world to test out your new real-time functionality.

## Where next?
