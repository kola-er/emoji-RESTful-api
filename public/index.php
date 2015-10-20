<?php
/**
 * This is a collection of routes for the entire application.
 *
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

require_once '../vendor/autoload.php';

use Slim\Slim;
use Kola\Api\Emoji\Helper\Setup;
use Kola\Api\Emoji\Auth\Authenticate;
use Kola\Api\Emoji\Middleware\Authorize;
use Kola\Api\Emoji\Controller\UserController;
use Kola\Api\Emoji\Controller\EmojiController;

// Make Slim instance
$app = new Slim;


// Login route
$app->post('/auth/login', function () use ($app) {
    echo Authenticate::login($app);
});

// Logout route
$app->get('/auth/logout', function () use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

    echo Authenticate::logout(Setup::getUserId($app), $app);
});

// Record retrieval route
$app->get('/emojis/:id', function ($id) use ($app) {
    echo EmojiController::get($id, $app);
});

// Record collection retrieval route
$app->get('/emojis', function () use ($app) {
    echo EmojiController::getAll($app);
});

// Record creation route
$app->post('/emojis', function () use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

    echo EmojiController::create(Setup::getUserId($app), $app);
});

// Record update route via PUT
$app->put('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::update($id, $app);
});

// Record update route via PATCH
$app->patch('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::update($id, $app);
});

// Record deletion route
$app->delete('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::delete($id, $app);
});

// Welcome
$app->get('/', function () {
	echo "<div style='background:url(img/emoji.jpg) no-repeat;background-size:cover'>" .
		"<div style='text-align:center;color:#E5E5E5;padding-top:300px'>" .
		"<h1>Welcome to Naijamoji.</h1>" .
		"<span style='font-weight:normal'>Register <a href='/register'>here</a></span>" .
		"</div>" .
		"</div>";
});

// User registration route
$app->get('/register', function () {
	echo "<div style='padding-left:600px;padding-top:300px'>" .
		"<form action='/register' method='post'>" .
		"Username: <input type='text' required autocomplete='off' name='username' placeholder='Enter a username' /><br>" .
		"Password: <input type='password' required autocomplete='off' name='password' placeholder='Enter a password' /><br>" .
		"Confirm Password: <input type='password' required autocomplete='off' name='password1' placeholder='Enter the password once more' /><br>" .
		"Purpose: <textarea name='purpose' required maxlength='50' rows='4' cols='50' placeholder='Why do you want to use our service?'></textarea><br>" .
		"<input type='submit' value='Register' />" .
		"</form>" .
		"</div>";
});

// Account creation for new users route
 $app->post('/register', function () use ($app){
	echo UserController::create($app);
});

// User account update route
$app->put('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::update($username, $app);
});

// User account update route
$app->patch('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::update($username, $app);
});

// User account deletion route
$app->delete('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::delete($username, $app);
});


// Run Slim instance
$app->run();