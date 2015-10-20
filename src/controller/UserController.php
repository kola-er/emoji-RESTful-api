<?php
/**
 * This class holds a set of background controller methods for users' accounts management.
 *
 * @package Kola\Api\Emoji\Controller\UserController
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\Api\Emoji\Controller;

use Slim\Slim;
use Kola\Api\Emoji\DbTable\User;
use Kola\PotatoOrm\Exception\RecordNotFoundException;

class UserController {
	/**
	 * Create a user account
	 *
	 * @param Slim $app
	 * @return string
	 */
	public static function create(Slim $app)
	{
		$app->response->headers->set('Content-Type', 'application/json');

		$fields = $app->request->post();

		if ((! empty($fields)) && (! is_null($fields['purpose']))) {
			if ($fields['password1'] == $fields['password']) {
				$user = new User;
				$user->username = $fields['username'];
				$user->password = md5($fields['password']);
				$user->token = NULL;
				$user->token_expire = NULL;
				$check = $user->save();

				if ($check === 1) {
					$userCreated = $user->where('username', $user->getRecord()['username'])->getRecord()['dbData']['username'];

					return json_encode(['username' => $userCreated, 'message' => 'Registration Complete! Go ahead and login to get a token.']);
				} else {
					$app->halt(503, json_encode(['message' => 'Confirm all fields have entry']));
				}
			} else {
				$app->halt(404, json_encode(['message' => 'Passwords did not match!']));
			}
		} else {
			$app->halt(422, json_encode(['message' => 'All fields must have entry']));
		}
	}

	/**
	 * Change a user's password
	 *
	 * string $username username of a user
	 * @param Slim $app
	 * @return string
	 */
	public static function update($username, Slim $app)
	{
		$app->response->headers->set('Content-Type', 'application/json');

		try {
			$user = User::where('username', $username);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
		}

		if (is_object($user)) {

			$fields = $app->request->isPut() ? $app->request->put() : $app->request->patch();
			$password = md5($fields['password']);

			if ($password == $user->getRecord()['dbData']['password']) {
				$user->password = $password;
				$check = $user->save;

				if ($check === 1) {
					return json_encode(['message' => 'Password Updated']);
				} else {
					$app->halt(304);
				}
			} else {
				$app->halt(401);
			}
		} else {
			$app->halt(503);
		}
	}

	/**
	 * Delete user's account
	 *
	 * @param string $username username of a user
	 * @param Slim $app
	 * @return string
	 */
	public static function delete($username, Slim $app)
	{
		$app->response->headers->set('Content-Type', 'application/json');

		try {
			$user = User::where('username', $username);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
		}

		if (is_object($user)) {

			$fields = $app->request->isPut() ? $app->request->put() : $app->request->patch();
			$password = md5($fields['password']);

			if ($password == $user->getRecord()['dbData']['password']) {
				$check = User::destroy($user->getRecord()['dbData']['id']);

				if ($check === 1) {
					return json_encode(['message' => 'Account Deleted']);
				} else {
					$app->halt(304);
				}
			} else {
				$app->halt(401);
			}
		} else {
			$app->halt(503);
		}
	}

}