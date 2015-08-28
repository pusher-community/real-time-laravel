# Building Real-Time Laravel Apps with Pusher

A GitBook for the Building Real-Time [Laravel](http://laravel.com) Apps with [Pusher](https://pusher.com) workshop.

You can find the current version of the Building Real-Time Laravel Apps with Pusher workshop here:

https://pusher-community.github.io/real-time-laravel/

## Prerequisites

In order to contribute to the workshop you'll need to do the following.

### GitBook

You will need to install the [GitBook CLI](https://github.com/GitbookIO/gitbook) globally:

```
$ npm install gitbook-cli -g
```

### NPM Dependencies

```
$ npm install
```

## How to Edit

Run:

```
$ gitbook serve src
```

Edit the source files in `src` and view the results in the GitBook running on `http://localhost:8000`.

## How to Deploy

Ensure the build works by building using:

```
$ gulp gitbook-generate
```

This will build the book to the `dist` directory. Run a server from this directory to test the built files.

To build to the `dist` directory and deploy to the gh-pages branch of the remote repository run:

```
$ gulp deploy
```
