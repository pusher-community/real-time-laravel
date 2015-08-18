## Triggering Activity Events

We clearly don't have time to build a full social network. But we can support a few simple activities in order to demonstrate how events can be used to represent each activity type.

## Create the Controller and View

<i class="fa fa-rocket fa-2"></i> Let's start by creating a plain controller:

```
› php artisan make:controller ActivityController --plain
```

<i class="fa fa-rocket fa-2"></i> Update the controller using the code below:

```php
use Illuminate\Support\Facades\App;

class ActivityController extends Controller
{
    var $pusher;

    public function __construct()
    {
        $this->pusher = App::make('pusher');
    }

    /**
     * Serve the example activities view
     */
    public function getIndex()
    {
        // TODO: trigger event
        return view('activities');
    }

    /**
     * A new status update has been posted
     * @param Request $request
     */
    public function postStatusUpdate(Request $request)
    {
        // TODO: trigger event
    }

    /**
     * Like an activity
     * @param $id The ID of the activity that has been liked
     */
    public function postLike($id)
    {
        // TODO: trigger event
    }
}
```

<i class="fa fa-rocket fa-2"></i> And create a `resources/views/activities.blade.php` file and copy & paste the contents of [THIS TEMPLATE](#) into it.

<i class="fa fa-rocket fa-2"></i> Finally, add an entry to your `app/Http/routes.php`:

```php
Route::controller('activities', 'ActivityController');
```

Now we want to trigger activity events.

## Triggering Activity Events

There are three potential types of activity in our `ActivityController`:

1. A user visits the Activities page
2. A new status update has been posted
3. A status update has been "liked"

<i class="fa fa-rocket fa-2"></i> For each event (`user-visit`, `new-status-update` and `status-update-liked`) trigger an event on a `activities` channel. Each event should contain some `text` to display about the event and a unique `id`. Since we're not going to be using a database let's just use `str_random()` to generate a unique ID.

```php
$data = ['text' => 'activity text', `id` => 'a unique ID'];
```

<i class="fa fa-rocket fa-2"></i> For the event that's triggered in the `postLike($id)` action also send the ID of the activity that the user liked on a `likedActivityId` property.

## Building the ActivityStream UI

The view, defined in `resources/views/activities.blade.php`, already has some functionality, but you still need to hook up the real-time events.

### User Visited

Whenever the `/activities` endpoint (`getIndex()` action) is access a `user-visit` event is triggered on the `activities` channel. 

<i class="fa fa-rocket fa-2"></i> If you haven't already done so, navigate to http://localhost:8000/activites endpoint in the browser and make sure the event is triggered by checking the Pusher Debug Console.

<i class="fa fa-rocket fa-2"></i> Once you're sure the event is being triggered you can subscribe to the `activites` channel on the client and bind to the event. There's already a `addUserVisit` that can be used to handle the event and add an activity to the stream UI.

### Status Updates

Next we should handle the status updates that users can post from the view.

<i class="fa fa-rocket fa-2"></i> Navigate to http://localhost:8000/activities and make sure that entering some text into the "What's your status?" input and pressing `enter` results in your `/activites/status-update` endpoint (`postStatusUpdate(Request $request)` action) being called. You can check this in two ways:

1. using the browser developer tools network tab
2. via the Pusher Debug Console

<i class="fa fa-rocket fa-2"></i> Once you know the status updates are hitting your endpoint and resulting in an event being triggered via Pusher you can bind to the `new-status-update` event. There's already a `addStatusUpdate` function that you can use to handle the event.

### Likes

Once you have status updates coming in you'll see that each activity has a small <span style="color:red;">&hearts;</span> (heart) icon that can be clicked. When it's clicked the `sendLike` function is called sending down the activity ID. This results in the `/activities/like` endpoint (`postLike($id)`) being called and the `status-update-liked` event being triggered on the `activities` channel.

<i class="fa fa-rocket fa-2"></i> Make sure that clicking the <span style="color:red;">&hearts;</span> (heart) icon does what it's supposed to - you know the drill!

Finally we want to wire up the incoming `status-update-liked` and update the UI. 

<i class="fa fa-rocket fa-2"></i> This one hasn't been implemented for you. Here are the steps to help:

* Bind to the event and create a callback handler
* Use the `addActivity(type, data)` function to add an activity stream element
* *Stretch Task:* Identify the element for activity that's been liked via the `data.likedActivityId` value and add a "Liked Count" value to the element with the class `.like-count` indicating the number of times that activity has been liked

Once complete it should look at little bit like this:

![Activity Streams workshop example](/assets/img/activity-streams-screenshot.png)

## What's next?

We've built real-time notification and activity streams. Next, it's the 101 or real-time technology where we can take everything we've learned and [build real-time chat](../chat).
