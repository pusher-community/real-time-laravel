<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />
    <link rel="stylesheet" type="text/css" href="https://pusher-community.github.io/real-time-laravel/assets/laravel_app/activity-stream-tweaks.css" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <script>
        // Ensure CSRF token is sent with AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Added Pusher logging
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>
</head>
<body>

<div class="stripe no-padding-bottom numbered-stripe">
    <div class="fixed wrapper">
        <ol class="strong" start="2">
            <li>
                <div class="hexagon"></div>
                <h2><b>Real-Time Activity Streams</b> <small>A stream of application consciousness.</small></h2>
            </li>
        </ol>
    </div>
</div>

<section class="blue-gradient-background">
    <div class="chat-app light-grey-blue-background">
        <form id="status_form" action="/activities/status-update" method="post">
            <div class="action-bar">
                <input id="status_text" name="status_text" class="input-message col-xs-9" placeholder="What's your status?" />
            </div>
        </form>

        <div class="time-divide">
            <span class="date">
              Today
            </span>
        </div>

        <div id="activities"></div>
    </div>
</section>

<script id="activity_template" type="text/template">
    <div class="message activity">
        <div class="avatar">
            <img src="" />
        </div>
        <div class="text-display">
            <p class="message-body activity-text"></p>
            <div class="message-data">
                <span class="timestamp"></span>
                <span class="likes"><span class="like-heart">&hearts;</span><span class="like-count"></span></span>
            </div>
        </div>
    </div>
</script>

<script>
    function init() {
        // set up form submission handling
        $('#status_form').submit(statusUpdateSubmit);

        // monitor clicks on activity elements
        $('#activities').on('click', handleLikeClick);
    }

    // Handle the form submission
    function statusUpdateSubmit() {
        var statusText = $('#status_text').val();
        if(statusText.length < 3) {
            return;
        }

        // Build POST data and make AJAX request
        var data = {status_text: statusText};
        $.post('/activities/status-update', data).success(statusUpdateSuccess);

        // Ensure the normal browser event doesn't take place
        return false;
    }

    // Handle the success callback
    function statusUpdateSuccess() {
        $('#status_text').val('')
        console.log('status update submitted');
    }

    // Creates an activity element from the template
    function createActivityEl() {
        var text = $('#activity_template').text();
        var el = $(text);
        return el;
    }

    // Handles the like (heart) element being clicked
    function handleLikeClick(e) {
        var el = $(e.srcElement || e.target);
        if (el.hasClass('like-heart')) {
            var activityEl = el.parents('.activity');
            var activityId = activityEl.attr('data-activity-id');
            sendLike(activityId);
        }
    }

    // Makes a POST request to the server to indicate an activity being `liked`
    function sendLike(id) {
        $.post('/activities/like/' + id).success(likeSuccess);
    }

    // Success callback handler for the like POST
    function likeSuccess() {
        console.log('like posted');
    }

    function addActivity(type, data) {
        var activityEl = createActivityEl();
        activityEl.addClass(type + '-activity');
        activityEl.find('.activity-text').html(data.text);
        activityEl.attr('data-activity-id', data.id);
        activityEl.find('.avatar img').attr('src', data.avatar);

        $('#activities').prepend(activityEl);
    }

    // Handle the user visited the activities page event
    function addUserVisit(data) {
        addActivity('user-visit', data);
    }

    // Handle the status update event
    function addStatusUpdate(data) {
        addActivity('status-update', data);
    }

    $(init);

    /***********************************************/

    var pusher = new Pusher('{{env("PUSHER_KEY")}}');

    // TODO: Subscribe to the channel

    // TODO: bind to each event on the channel
    // and assign the appropriate handler
    // e.g. 'user-visit' and 'addUserVisit'
    
    // TODO: bind to the 'status-update-liked' event,
    // and pass in a callback handler that adds an
    // activitiy to the UI using they
    // addActivity(type, data) function

</script>

</body>
</html>
