# Pusher Features

We've just scratched the surface of what Pusher can do and focused on showing how they can help you build notifications, activity streams and chat. But what else can Pusher do and what else can you build? That's the whole point of this section!

## Multi-Channel Publishing

Pusher provides a way of triggering the same event on multiple channels.

This can be useful in applications where your channel information architecture requires users to subscribe to unique channels, but where you still want those users to recieve the same events.

For example, if each user subscribes to their own authenticated notifications channel (e.g. `private-username-notifications`). If a user called `leggetter` and a user called `olga` were interested in a notification, Pusher's Multi-Channel Publishing functionality let's you trigger the same event on the notifications channel for both of these users:

```php
$channels = [
    'private-leggetter-notifications',
    `private-olga-notifications`
];

$pusher->trigger($channels, 'new-notifications', ['text' => '...']);
```

## Live User Lists (Presence)

Pusher provides special channels called [Presence channels](https://pusher.com/docs/presence_channels) that allow you to build live user lists such as the ones you see in many chat applications.

Presence channels require authentication. As part of that authentication process your authentication endpoint can also provide information about the current user that is then distributed to clients to allow you to add UI logic to show who is online. In addition, special `pusher:member_added` and `pusher:member_removed` events are triggered on presence channels to let you update your UI to show users coming online and going offline.

For more information see [Presence channels](https://pusher.com/docs/presence_channels) and [Authenticating Users](https://pusher.com/docs/authenticating_users).

## Client Events

As well as being able to trigger events via Pusher from the server via the HTTP API, authenticated users can also trigger events from the client on Private and Presence channels.

Take a look at the [client events docs](https://pusher.com/docs/client_events) for more information.

## Channel Queries

The Pusher HTTP API also provides a way of querying for information on channels. This includes:

* which channels have subscribers at any given point
* specific information about channels e.g. how many subscribers does a channel have or which users are subscribed to a presence channnel

For more information see the [querying application state docs](https://pusher.com/docs/server_api_guide/interact_rest_api#querying-application-state).

## WebHooks

When you use a hosted service, that service tends to know information about what's going on within parts application that isn't available to your application server. [Pusher WebHooks](https://pusher.com/docs/webhooks) provide a mechanism for your application server to receive HTTP `POST` requests when certain events happen within your Pusher application:

* A channel becomes occupied or is vacated
* A user joins or leaves a Presence channel

For more information see the [WebHooks docs](https://pusher.com/docs/webhooks).

## Where next?

That's all folks! Finally, you can head to a (list of resources)[./resources.md] related to everything we've covered in this workshop.
