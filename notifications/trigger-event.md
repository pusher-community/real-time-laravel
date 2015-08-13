# Triggering a Notification Event

* Create a route
* Create a controller and action
* Trigger an event when an action takes place. Use debug console to verify.
* Verify or debug

In the code above we're firstly getting the `Pusher` instance from the service container. Then we're triggering an event called `test-event` on a channel with the name `test-channel`. The event payload is an `array` that the Pusher library will deserialise to `{"text": "Preparing the Pusher Laracon.eu workshop!"}` and send though Pusher.


## Sending a Notifications

The most simple use case for Pusher is to notify a user that something has happened.
