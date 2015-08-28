<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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
        <ol class="strong" start="1">
            <li>
                <div class="hexagon"></div>
                <h2><b>Real-Time Notifications</b> <small>Let users know what's happening.</small></h2>
            </li>
        </ol>
    </div>
</div>

<section class="blue-gradient-background splash">
    <div class="container center-all-container">
        <form id="notify_form" action="/notifications/notify" method="post">
            <input type="text" id="notify_text" name="notify_text"
                   placeholder="What's the notification?" minlength="3" maxlength="140" required />
        </form>
    </div>
</section>

<script>
function notifyInit() {
  // set up form submission handling
  $('#notify_form').submit(notifySubmit);
}

// Handle the form submission
function notifySubmit() {
  var notifyText = $('#notify_text').val();
  if(notifyText.length < 3) {
    return;
  }

  // Build POST data and make AJAX request
  var data = {notify_text: notifyText};
  $.post('/notifications/notify', data).success(notifySuccess);

  // Ensure the normal browser event doesn't take place
  return false;
}

// Handle the success callback
function notifySuccess() {
  console.log('notification submitted');
}

$(notifyInit);
</script>

</body>
</html>
