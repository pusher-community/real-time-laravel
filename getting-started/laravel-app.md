# Laravel App Setup

This is a workshop on how to use Pusher to add awesome real-time features to your Laravel apps. It's purpose isn't to teach you how to use Laravel, but we'll do our best to provide all the steps required to go through the workshop.

So, let's create a Laravel app.

<div class="alert alert-info">
    This workshop has been written using Laravel 5.1. So, it's assumed you have Laravel installed. If not, please following the <a href="http://laravel.com/docs/5.1/installation">official Laravel installation guide</a>.
</div>

## Create a Laravel app

Navigate to a directory in which you want your Laravel application to be created. We're going to create an application called `real-time-app`.

If you have the `laravel` executable on your PATH you can use:

```
› laravel new real-time-app
```

Otherwise, you can use composer:

```
› composer create-project laravel/laravel real-time-app --prefer-dist
```

Navigate into the newly created `real-time-app` directory and open the contents in your favourite editor.

<div class="alert alert-info">
    Right now our favourite editor is GitHub's <a href="https://atom.io/">Atom Editor</a>. But that's probably because we've created a pretty sweet real-time code collaboration plugin for it called <a href="https://atom.io/packages/atom-pair">Atom Pair</a>.
</div>

## Run the app

To make sure everything is working, run the newly created application. From a the `real-time-app` directory in the terminal or console window run the following:

```
› php artisan serve
```

## Where next?

Yipee! The app is created and running. Next, let's store the Pusher application credentials we've got in [environment variables](./setting-env-vars.md).
