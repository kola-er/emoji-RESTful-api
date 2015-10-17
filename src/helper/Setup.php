<?php
/**
 * This is a collection of helper methods.
 *
 * @package Kola\Api\Emoji\Helper\Setup
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\Api\Emoji\Helper;

use Slim\Slim;
use Kola\Api\Emoji\DbTable\User;
use Kola\PotatoOrm\Exception\RecordNotFoundException;

class Setup {
	/**
	 * Load Dotenv to grant getenv() access to environment variables in .env file
	 */
	public static function loadDotenv()
	{
		$dotenv = new \Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
		$dotenv->load();
	}

	/**
	 * Set timezone for the application
	 */
	public static function setTimezone() {
		self::loadDotenv();
		date_default_timezone_set(getenv('LOCATION'));
	}

	/**
	 * Disable token
	 *
	 * @param User $user Registered user
	 * @return bool|string Confirmation for disabling token
	 */
	public static function unsetToken(User $user) {
		$user->token = NULL;
		$user->token_expire = NULL;

		return $user->save();
	}

	/**
	 * Set token
	 *
	 * @param User $user Registered token
	 * @param string $token Access token
	 * @return bool|string Confirmation for setting token
	 */
	public static function setToken(User $user, $token) {
		self::setTimezone();

		$user->token = $token;
		$user->token_expire = date('Y-m-d H:i:s', strtotime('+30 minutes'));

		return $user->save();
	}

	/**
	 * Get ID of user with supplied token
	 *
	 * @param Slim $app
	 * @return mixed ID of user with supplied token
	 */
	public static function getUserId(Slim $app)
	{
		return self::getUserWithToken($app)->getRecord()['dbData']['id'];
	}

	/**
	 * Get user instance with supplied token
	 *
	 * @param Slim $app
	 * @return object|string
	 */
	public static function getUserWithToken(Slim $app)
	{
		$token = $app->request->headers('Authorization');

		if (isset($token)) {
			try {
				$user = User::where('token', $token);
			} catch (RecordNotFoundException $e) {
				$app->response->headers->set('Content-Type', 'application/json');
				$app->halt(401, json_encode(['message' => 'Invalid Token']));
			}

			return $user;
		} else {
			$app->response->headers->set('Content-Type', 'application/json');
			$app->halt(401, json_encode(['message' => 'Empty Token']));
		}
	}

	/**
	 * Turn a string in an array to array
	 *
	 * @param array $record
	 * @return array $record
	 */
	public static function format(Array $record) {
		$record['keyword'] = explode(' ', $record['keyword']);

		return $record;
	}
}