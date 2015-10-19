<?php
/**
 * This class takes care of users authentication.
 *
 * @package Kola\Api\Emoji\Auth\Authenticate
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\Api\Emoji\Auth;

use Slim\Slim;
use Kola\Api\Emoji\DbTable\User;
use Kola\Api\Emoji\Helper\Setup;
use Kola\PotatoOrm\Exception\RecordNotFoundException;

class Authenticate
{
	/**
	 * Issue token to a user
	 *
	 * @param Slim $app
	 * @return string
	 */
	public static function login(Slim $app) {
		$app->response->headers->set('Content-Type', 'application/json');

		$username = $app->request->post('username');
		$password = $app->request->post('password');

		try {
			$user = User::where('username', $username);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Registered']));
		}

		if ($password == $user->getRecord()['dbData']['password']) {
			$token = bin2hex(openssl_random_pseudo_bytes(16));
			$test = Setup::setToken($user, $token);

			if ($test === 1) {
				return json_encode(['username' => $username, 'Authorization' => $token]);
			} else {
				$app->halt(503);//, json_encode(['message' => $test]));
			}
		} else {
			$app->halt(404, json_encode(['message' => 'Incorrect password']));
		}
	}

	/**
	 * Disable issued token to a user
	 *
	 * @param int $user_id ID of a user
	 * @param Slim $app
	 * @return string
	 */
	public static function logout($user_id, Slim $app) {
		$app->response->headers->set('Content-Type', 'application/json');

		try {
			$user = User::find($user_id);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Registered']));
		}

		if (Setup::unsetToken($user) === 1) {
			return json_encode(['message' => 'Logged out']);
		} else {
			$app->halt3(503);
		}
	}
}
