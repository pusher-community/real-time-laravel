# Bridge v Event Broadcasting <i class="fa fa-graduation-cap fa-2"></i>

By using the bridge instead of Event Broadcasting you don't need to adhere to some of the Event Broadcasting rules and it provides consistency when it comes to accessing the `Pusher` instance for other pieces of Pusher functionality such as [authenticating channel subscriptions](#), [querying application state](#) (such as channels that have active subscriptions) and validating incoming [Pusher WebHooks](https://pusher.com/docs/webhooks).

However, by using using event broadcasting you are completely decoupling your back-end functionality from having any reliance on Pusher's broadcast messaging which means you can quickly switch out the message broadcasting service that you're using.

Make the best choice for your app.

## Which one will we use?

To keep things simple, **we're going to be using the vikla/pusher Laravel Pusher Bridge for the rest of the workshop**.

## Where next?

Let's admit it, somethings things don't work. So, let's see how you can [debug your Pusher server-side integration](./server-debugging.md).
