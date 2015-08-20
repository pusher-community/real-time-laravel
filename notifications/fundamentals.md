# Real-Time Fundamentals <i class="fa fa-graduation-cap fa-2"></i>

So we're going to build real-time notifications into a Laravel application by creating a [controller](http://laravel.com/docs/5.1/controllers) dedicated to triggering notifications and a [view](http://laravel.com/docs/5.1/views) to allow users to create those notifications. 

But first, lets' review some of the key Pusher concepts.

## Channels, Events & Event Data

Three fundamental concepts in Pusher are: channels, events and event data.

[Channels](https://pusher.com/docs/channels) are used to identify the context of data within your application; this frequently maps to data being stored in a database. Since we're building a notification feature it'll make sense to name our channel `notifications`.

If Channels identify the data then [Events](https://pusher.com/docs/client_api_guide/client_events) represent something happening to that data. If we think about databases this could be any CRUD (Create, Read, Update, Delete) event. In the context of notifications this could mean:

* A new notification has been created
* A notification has been read
* An existing notification has been updated (modified)
* An existing notification has been deleted/destroyed (or maybe marked as no longer relevant and simply archived)

For our feature let's give the event a name of `new-notification`. We'll use this instead of `created` as it provides better semantics.

Each event has an **Event Data** payload. In our simple use case we're going to supply just the text for the notification. But in a more real world use case you would also likely provide information that can be used to allow the user to perform some sort of action on the notification e.g. click through to view more detailed information.

So, our data may look like:

```php
$data = array('text' => 'this is a notification');
```

Or even:

```php
class Notification
{
    public $text;
    
    public function __construct($text)
    {
        $this->text = $text;
    }
}

$data = new Notification('this is a notification');
```

The Pusher PHP library (and all other libraries) will handles serialising and deserialising data. In both cases above, triggering an event with the `$data` event payload will result in the same information being sent through Pusher and received by the client. The JSON representation of the above event data will look as follows:

```
{"text": "this is a notification"}
```

Now that you've an overview of channels, events and event data the following code will make much more sense to you:

```php
$pusher->trigger('notifications', 
                 'new-notification', 
                 ['text' => 'this is a notification']);
```

## Where next?

It's time to [trigger a notification events](./trigger-event.md).
