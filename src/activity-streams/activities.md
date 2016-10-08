## Triggering Activity Events

We clearly don't have time to build a full social network. But we can support a few simple activities in order to demonstrate how events can be used to represent each activity type.

## Create the Controller and View

<i class="fa fa-rocket fa-2"></i> Save the [ActivityController.php template](../assets/laravel_app/ActivityController.php) to `app/Http/Controllers/ActivityController.php`.

Here's the code in full followed by some explanation:

!CODEFILE "../assets/laravel_app/ActivityController.php"

In the code above you'll notice that the `__construct()` attempts to grab the user from the `Session` and in `getIndex()` the value of `$this->user` is checked. If there isn't a logged in user the app redirects in order for the user to log in. 

By having a user we can identify who has triggered an activity event. There's an example in the code above of getting both the `username` and `avatar`. This can then be used when we trigger events via Pusher, and ultimately display that information in our user interface.

<i class="fa fa-rocket fa-2"></i> The `ActivityController` relies on an `activities` view so let's create that. Save the [activities.blade.php template](../assets/laravel_app/activities.blade.php) to `resources/views/activities.blade.php`.

<i class="fa fa-rocket fa-2"></i> Finally, add an entry to your `app/Http/routes.php`:

```php
Route::controller('activities', 'ActivityController');
```

Now we want to trigger activity events.

## Triggering Activity Events

There are three potential types of activity in our `ActivityController`:

1. A user visits the Activities page: `user-visit`
2. A new status update has been posted: `new-status-update`
3. A status update has been "liked": `status-update-liked`

<i class="fa fa-rocket fa-2"></i> For each event trigger an event on an `activities` channel. Each event should contain some `text` to display about the event, a `username` and an `avatar` to identify who triggered the event, and a unique `id`. Since we're not going to be using a database let's just use `str_random()` to generate a unique ID.

For example:

```php
$activity = [
    'text' => $this->user->getNickname() . ' has visited the page',
    'username' => $this->user->getNickname(),
    'avatar' => $this->user->getAvatar(),
    'id' => str_random()
];

$this->pusher->trigger('activities', 'user-visit', $activity);
```

<div class="alert alert-info">
  It's a little trickier to test that some of these events can be triggered. But you can at least test the <code>user-visit</code> event is being triggered in the <strong>Pusher Debug Console</strong>.
</div>

<i class="fa fa-rocket fa-2"></i> For the event that's triggered in the `postLike($id)` action also send the ID of the activity that the user liked on a `likedActivityId` property using the `$id` value.

```php
$activity = [
    // Other properties...
    
    'likedActivityId' => $id
];
```

## Building the ActivityStream UI

The view, defined in `resources/views/activities.blade.php`, already has some functionality, but you still need to hook up Pusher and the real-time events.

### User Visited

Whenever the `/activities` endpoint (`getIndex()` action) is accessed, a `user-visit` event is triggered on the `activities` channel. 

<i class="fa fa-rocket fa-2"></i> If you haven't already done so, navigate to http://localhost:8000/activities endpoint in the browser and make sure the event is triggered by checking the Pusher Debug Console.

<i class="fa fa-rocket fa-2"></i> Once you're sure the event is being triggered you can add JavaScript to the view to `subscribe` to the `activites` channel on the client and `bind` to the `user-visit` event. There's already a `addUserVisit` that can be used to handle the event and add an activity to the stream UI.

<div class="alert alert-info">
  You can test out functionality such as user page visit events by having two browser windows side-by-side.
</div>

### Status Updates

Next we should handle the status updates that users can post from the view.

<i class="fa fa-rocket fa-2"></i> Navigate to http://localhost:8000/activities and make sure that entering some text into the "What's your status?" input and pressing `enter` results in your `/activites/status-update` endpoint (`postStatusUpdate(Request $request)` action) being called.

You can check this in two ways:

1. using the browser developer tools network tab
2. via the Pusher Debug Console

<i class="fa fa-rocket fa-2"></i> Once you know the status updates are hitting your endpoint and resulting in an event being triggered via Pusher you can bind to the `new-status-update` event. There's already a `addStatusUpdate` function that you can use to handle the event.

### Likes

Once you have status updates coming in you'll see that each activity has a small <span style="color:red;">&hearts;</span> (heart) icon that can be clicked. When it's clicked the `sendLike` function is called sending down the activity ID. This results in the `/activities/like` endpoint (`postLike($id)`) being called and the `status-update-liked` event being triggered on the `activities` channel.

<i class="fa fa-rocket fa-2"></i> Make sure that clicking the <span style="color:red;">&hearts;</span> (heart) icon does what it's supposed to - you know the drill!

Finally we want to wire up the incoming `status-update-liked` and update the UI. 

<i class="fa fa-rocket fa-2"></i> This one hasn't been implemented for you. Here are the steps to help:

* Bind to the event and create a callback handler function
* Use the `addActivity(type, data)` function to add an activity stream element
* *Stretch Task:* Identify the element for activity that's been liked via the `data.likedActivityId` value and add a "Liked Count" value to the element with the class `.like-count` indicating the number of times that activity has been liked

Once complete it should look at little bit like this:

![Activity Streams workshop example](/assets/img/activity-streams-screenshot.png)

## What's next?

Let's go over [what we've covered in this section](./learned.md).
