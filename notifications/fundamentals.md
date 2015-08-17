# Real-Time Fundamentals

So we're going to build real-time notifications into a Laravel application by creating a controller dedicated to triggering notifications and a UI to allow users to create those notifications. 

But first, lets' review some of the key Pusher concepts.

## Channels, Events & Event Data

Three fundamental concepts in Pusher are: channels, events and event data.

**Channels** are used to identify the context of data within your application; this frequently maps to data being stored in a database. Since we're building a notification feature it'll make sense to name our channel `notifications`.

If Channels identify the data then **Events** represent something happening to that data. If we think about databases this could be any CRUD (Create, Read, Update, Delete) event. In the context of notifications this could mean:

* A new notification has been created
* A notification has been read
* An existing notification has been updated (modified)
* An existing notification has been deleted (or maybe marked as no longer relevant and simply archived)

For our feature let's give the event a name of `new-notification`. We'll use this instead of `created` as it provides better semantics.

Each event has an **Event Data** payload. In our simple use case we're going to supply just the text for the notification. But in a more real world use case you would also likely provide information that can be used to allow the user to perform some sort of action on the notification e.g. click through to view more detailed information.

So, our data may look like:

```php
$data = array('text' => 'this is a notification');
```

The Pusher PHP library (and all other libraries) will handles serialising and deserialising data. The JSON representation of the above event data will look as follows:

```
{"text": "this is a notification"}
```

Now that you've an overview of channels, events and event data the following code will make much more sense to you:

```php
$pusher->trigger('notifications', 
                 'new-notification', 
                 array('text' => 'this is a notification'));
```

## Where next?

[Trigger a notification event](./trigger-event.md).
