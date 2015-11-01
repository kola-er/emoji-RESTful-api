<?php
/**
 * This is a collection of access control middleware.
 *
 * @package Kola\Api\Emoji\Middleware\Authorize
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\Api\Emoji\Middleware;

use DateTime;
use Slim\Slim;
use Kola\Api\Emoji\Helper\Setup;
use Kola\Api\Emoji\DbTable\Emoji;
use Kola\PotatoOrm\Exception\RecordNotFoundException;

class Authorize
{
	/**
	 * Validate token
	 *
	 * @param Slim $app
	 * @return bool
	 */
    public static function validateToken(Slim $app)
    {
        Setup::setTimezone();

        $user = Setup::getUserWithToken($app);

        $tokenExpire = $user->getRecord()['dbData']['token_expire'];
        $timeNow = new DateTime();
        $expiryTime = new DateTime($tokenExpire);

        if ($timeNow->getTimestamp() < $expiryTime->getTimestamp()) {
            return true;
        } else {
            Setup::unsetToken($user);
            $app->response->headers->set('Content-Type', 'application/json');
            $app->halt(401, json_encode(['message' => 'Expired Token']));
        }
    }

	/**
	 * Verify a resource owner
	 *
	 * @param $id
	 * @param Slim $app
	 * @return bool
	 */
    public static function grantAccess($id, Slim $app)
    {
		try {
			$emoji = Emoji::find($id);

		} catch (RecordNotFoundException $e) {
			$app->response->headers->set('Content-Type', 'application/json');
			$app->halt(404, json_encode(['message' => 'Not Found']));
		}

        if ($emoji->getRecord()['dbData']['user_id'] === Setup::getUserId($app)) {
            return true;
        } else {
			$app->response->headers->set('Content-Type', 'application/json');
			$app->halt(401, json_encode(['message' => 'Not yours']));
        }
    }
}
