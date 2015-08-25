# Super Simple Social Auth

To give an activity more context it's important to know who is triggering that activity. So, we need some form of authentication resulting in an associated logged in user.

For each component we add to an application we increase its complexity - something we want to avoid in this workshop. For that reason we're going to avoid adding a database dependency. Instead, we're going to use social login using the [Socialite](https://github.com/laravel/socialite/) package and simply store the authenticated user information in the `Session`. **This isn't a production grade solution**, but it helps us get simple authentication added to our application in super-quick time.

<i class="fa fa-rocket fa-2"></i> Since [GitHub](https://github.com) is referred to in the Socialite documentation we're going to use it for our social login. So, you'll need a GitHub account.

## Install Socialite

<i class="fa fa-rocket fa-2"></i> Run the following command from a terminal or console:

```
composer require laravel/socialite
```

<i class="fa fa-rocket fa-2"></i> Then add the provider to `config/app.php`:

```php
'providers' => [
    // Other service providers...

    Laravel\Socialite\SocialiteServiceProvider::class,
],
```

<i class="fa fa-rocket fa-2"></i> Finally, add the Facade:

```php
'aliases' => [
    // Other aliases
    
    'Socialite' => Laravel\Socialite\Facades\Socialite::class,
],
```

<div class="alert alert-info">
  For more detailed instructions see the <a href="http://laravel.com/docs/5.1/authentication#social-authentication">official Laravel Socialite docs</a>
</div>

## Get GitHub Credentials

In order to use GitHub social login your application needs to be registered with GitHub.

### Instructor-lead Workshop <i class="fa fa-graduation-cap fa-2"></i>

<i class="fa fa-rocket fa-2"></i> If you're in an instructor-lead workshop **and you are running your app from `http://localhost:8000` then they'll provide you with some credentials that you can use. If your app isn't running from `localhost:8000` then you'll need to *Create your own GitHub App*.

### Self Taught Workshop / Create your own GitHub App

<i class="fa fa-rocket fa-2"></i> If you'd like to register your own application or you're going through this without an instructor then you'll need to create an application. The steps are:

1. Login to [GitHub](https://github.com)
2. Go to your settings (top-right drop-down -> Settings)
3. Select **Applications** from the menu
4. Select the **Developer applications** tab
5. Click **Register new application**
6. Enter a name, If using `localhost:8000`:
  * Use `http://localhost:8000` as the home page
  * `http://localhost:8000/auth/github/callback` as the **Authorization callback URL**
7. Click **Register application**

## Store GitHub Credentials

**Everybody needs to now do the following exercises.**

<i class="fa fa-rocket fa-2"></i> Now, open up the `.env` file in your Laravel application and take the values from the GitHub application settings and put them into the `.env` file.

```
GITHUB_CLIENT_ID=YOUR_CLIENT_ID
GITHUB_CLIENT_SECRET=YOUR_CLIENT_SECRET
GITHUB_CALLBACK_URL=YOUR_GITHUB_CALLBACK_URL
```

If you're running on `localhost:8000` this will be `http://localhost:8000/auth/github/callback`.

We now need to tell Socialite about these configuration values. To do that open up `config/services.php` and add a `github` entry:

```php
return [
    // Other service config

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
    ],

];
```

## Add Login Functionality

After setting up the Socialite provider and Alias we need to set up an `AuthController` and some routes.

<i class="fa fa-rocket fa-2"></i> Open up `app/Http/Controllers/Auth/AuthController.php` and replace the contents with the following:

```php
<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;

use Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     * Also passes a `redirect` query param that can be used
     * in the handleProviderCallback to send the user back to
     * the page they were originally at.
     *
     * @param Request $request
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        return Socialite::driver('github')
            ->with(['redirect_uri' => env('GITHUB_CALLBACK_URL' ) . '?redirect=' . $request->input('redirect')])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * If a "redirect" query string is present, redirect
     * the user back to that page.
     *
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('github')->user();

        Session::put('user', $user);

        $redirect = $request->input('redirect');
        if($redirect)
        {
            return redirect($redirect);
        }
        return 'GitHub auth successful. Now navigate to a demo.';
    }
}
```

You'll noticed that `redirectToProvider` redirects to GitHub social login and `handleProviderCallback` handles the auth callback from GitHub and adds the user to the `Session`.

<i class="fa fa-rocket fa-2"></i> To set up our routes simply open up `app/Http/Routes.php` and add the following so that the `AuthController` functions are called; `/auth/github` to redirect to GitHub login and `auth/github/callback` to handle the GitHub auth callback.

```php
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
```

There are a few steps here. But hopefully you managed to get it done quite quickly!

## Testing GitHub Social Auth

We're finally in a position to test that our GitHub social login is working.

<i class="fa fa-rocket fa-2"></i> Navigate to http://localhost:8000/auth/github and you should be redirected to GitHub to login. Once you allow the application to access your basic information you should be redirected back to `http://localhost:8000/auth/github/callback?code=...&redirect=&state=...`. If you get the `GitHub auth successful` text it means things are working!

<div class="alert alert-warning">
  <p><strong>cURL error 60: SSL certificate problem: unable to get local issuer certificate</strong></p>
  <p>If you see this issue then you're likely running Windows. The fix to this is:</p>
  <ul>
    <li>Download file: <a href="http://curl.haxx.se/ca/cacert.pem" target="_blank">curl.haxx.se/ca/cacert.pem</a></li>
    <li>Update your `php.ini` to include the following:<br />
      <code>curl.cainfo = "[path_to_location]\cacert.pem"</code>
    </li>
    <li>Restart your web server</li>
  </ul>
</div>

We now have access to the GitHub user information via `Session::get('user')` and we'll make use of that shortly.

## Where next?

It's now time to [Trigger Activity Events](./activities.md).
