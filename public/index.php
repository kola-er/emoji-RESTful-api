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
		"<div style='text-align:center;padding-top:150px'><h1>Welcome to Naijamoji. <span style='font-weight:normal'>Register <a href='/register'>here</a></span></h1></div>" .
		"</div>";
});

$app->get('/register', function () {
	echo '<form action="/register" method="post">' .
		'<label>Username: </label>' .
		'<input type="text" name="username" placeholder="Enter a username" />' .
		'<label>Password: </label>' .
		'<input type="password" name="password" placeholder="Enter a password" />' .
		'<label>Confirm Password: </label>' .
		'<input type="password" name="password1" placeholder="Enter the password once more" />' .
		'<input type="submit" value="Register" />' .
		'</form>';
});

$app->post('/register', function () use ($app){
	echo UserController::create($app);
});

$app->put('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::update($username, $app);
});

$app->patch('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::update($username, $app);
});

$app->delete('/user/:username', function ($username) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	echo UserController::delete($username, $app);
});

// Run Slim instance
$app->run();