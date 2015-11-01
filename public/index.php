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
use Kola\Api\Emoji\Helper\HtmlDisplay;
use Kola\Api\Emoji\Middleware\Authorize;
use Kola\Api\Emoji\Controller\UserController;
use Kola\Api\Emoji\Controller\EmojiController;

// Make Slim instance
$app = new Slim;


/**------------Authentication------------**/
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


/**------------Emoji Management------------**/
// Emoji retrieval route
$app->get('/emojis/:id', function ($id) use ($app) {
    echo EmojiController::get($id, $app);
});

// Emoji collection retrieval route
$app->get('/emojis', function () use ($app) {
    echo EmojiController::getAll($app);
});

// Emoji creation route
$app->post('/emojis', function () use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

    echo EmojiController::create(Setup::getUserId($app), $app);
});

// Emoji update route via PUT
$app->put('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::update($id, $app);
});

// Emoji update route via PATCH
$app->patch('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::update($id, $app);
});

// Emoji deletion route
$app->delete('/emojis/:id', function ($id) use ($app) {
	// Token validation middleware
	Authorize::validateToken($app);

	// Access grant middleware
	Authorize::grantAccess($id, $app);

    echo EmojiController::delete($id, $app);
});


/**------------Web interface------------**/
// Welcome
$app->get('/', function () {
	echo HtmlDisplay::welcome('img/emoji.jpg');
});

// User registration form route
$app->get('/register', function () {
	echo HtmlDisplay::form();
});


/**------------User account Management------------**/
// Account creation for new users route
 $app->post('/register', function () use ($app){
	echo UserController::create($app);
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