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


// Run Slim instance
$app->run();