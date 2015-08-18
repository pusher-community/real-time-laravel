# Using the Pusher JavaScript library

Now that everything is working on the server-side it's time to turn to the client-side and look at adding the Pusher JavaScript library to the app so that the events that are being triggered on the server can be received on the client.

<i class="fa fa-rocket fa-2"></i> Open up `resources/views/welcome.blade.php` and include the following script:

```html
<script src="//js.pusher.com/3.0/pusher.min.js"></script>
<script>
var pusher = new Pusher("{{env('PUSHER_KEY')}}")
var channel = pusher.subscribe('test-channel');
channel.bind('test-event', function(data) {
  alert(data.text);
});
</script>
```

<i class="fa fa-rocket fa-2"></i> To test this is working:

1. Open up the Pusher Debug Console for your application in a tab or window
2. Open http://localhost:8000/bridge in one browser window
3. Take a look at the Pusher Debug Console. Along with any other log entries you should see a *Connection* and *Subscribe*. Things are looking good.
4. Open the same URL in a 2nd window
5. Be *amazed* by an alert box

Okay, you won't be amazed. But this proves that the event is making it's way to the web browser.

*Not seeing the alert? Read on...*

## Where next?

Once you've [debugged your server-side integration](./server-debugging.md) and are sure that your events are reaching Pusher, you'll want to [debug your Pusher JavaScript integration](./pusher-js-debugging.md).
