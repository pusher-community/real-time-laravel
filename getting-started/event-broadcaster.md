# Using Laravel Event Broadcasting

By using Laravel 5.1 you already have the Pusher library integrated into your application so there's no installation required. We've already done all the set up we need when we set our environment variables.

<div class="alert alert-info">
  The Pusher Event Broadcaster is configured in <code>config/broadcasting.php</code>. Luckily it's the default broadcaster so we don't actually need to configure anything.
</div>

Laravel 5.1 comes with an in-built Pusher Event Broadcaster that we're going to use. To use this we need to follow a few conventions. 

<i class="fa fa-rocket fa-2"></i> Firstly, we need to define a class that represents our event. For simplicity we'll add this directly to `app/Http/routes.php` for now.

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

As with the previous example, we'll go in to the details of channels and events in a later exercise.

<i class="fa fa-rocket fa-2"></i> Next, update the contents of the `app/Http/routes.php` file with the following:

```php
get('/broadcast', function() {
    event(new TestEvent('Broadcasting in Laravel using Pusher!'));
    
    return view('welcome');
});
```

<i class="fa fa-rocket fa-2"></i> As before, to test:

1. Open up the Pusher Debug Console for your Pusher application
2. Ensure your Laravel application is running (`php artisan serve`)
3. In a new browser tab or window, navigate to the `/broadcast` route in the Laravel app (or simply refresh your tab), http://localhost:8000/broadcast

Again, you'll see the event appear in the Pusher Debug Console. It's working!

<div class="alert alert-warning">
  <strong>It's not working!</strong> Oh no, Something has gone wrong. Don't worry, we'll work out what's happening in an upcoming section on <strong>Debugging your server-side integration with Pusher</strong>.
</div>

## Where next?

When things don't work as expected it's really useful to be able to [debug your server-side integration with Pusher](./server-debugging.md).
