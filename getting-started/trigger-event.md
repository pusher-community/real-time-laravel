# Trigger an Event

Now that we've integrated Pusher into our Laravel application we want to start sending messages - since this is real-time, when using Pusher we call this "triggering events". 

An event has a name and a data payload (the message) and is triggered on a channel. Channels are used to identify the context of the event. Normally this is data within a system and the event indicates that something has happened to that data.

This maps really well to CRUD (Create, Read, Update and Delete) operations. In this case the channel will either represent a table in a database or a single record or entity and the event will represent a new row or entity has been added to the database, or that an existing entity has been updated or deleted.

## Triggering events via the Laravel Pusher Wrapper

* Create a route
* Create a controller and action
* Trigger an event when an action takes place. Use debug console to verify.
* Verify or debug

In the code above we're firstly getting the `Pusher` instance from the service container. Then we're triggering an event called `test-event` on a channel with the name `test-channel`. The event payload is an `array` that the Pusher library will deserialise to `{"text": "Preparing the Pusher Laracon.eu workshop!"}` and send though Pusher.

## Triggering events via the Event Broadcaster

This class constructor takes a simple `$text` string and assigns it to a public property. The class implements the `ShouldBroadcast` interface meaning that it needs to define a `broadcastOn` function and return an `array` of channels you wish the event should be published on.


## Sending a Notifications

The most simple use case for Pusher is to notify a user that something has happened.
