<?php
/**
 * This class holds a set of background controller methods for all interface routes of the application.
 *
 * @package Kola\Api\Emoji\Controller\EmojiController
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */

namespace Kola\Api\Emoji\Controller;

use Slim\Slim;
use Kola\Api\Emoji\Helper\Setup;
use Kola\Api\Emoji\DbTable\Emoji;
use Kola\PotatoOrm\Exception\EmptyTableException;
use Kola\PotatoOrm\Exception\RecordNotFoundException;

class EmojiController
{
	/**
	 * Retrieve an emoji resource
	 *
	 * @param int $id ID of a user
	 * @param Slim $app
	 * @return string
	 */
    public static function get($id, Slim $app)
    {
        $app->response->headers->set('Content-Type', 'application/json');

        try {
            $emoji = Emoji::find($id);
        } catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
        }

        if (is_object($emoji)) {
			return json_encode(Setup::format($emoji->getRecord()['dbData']));
        } else {
			$app->halt(503);
        }
    }

	/**
	 * Retrieve a collection of emoji resources
	 *
	 * @param Slim $app
	 * @return string
	 */
    public static function getAll(Slim $app)
    {
		$app->response->headers->set('Content-Type', 'application/json');

        try {
            $emojis = Emoji::getAll();
        } catch (EmptyTableException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
        }

        if (is_array($emojis)) {
			$emojisRestructured = [];

			foreach ($emojis as $emoji) {
				array_push($emojisRestructured, Setup::format($emoji));
			}

			return json_encode($emojisRestructured);
        } else {
			$app->halt(503);
        }
    }

	/**
	 * Create an emoji resource
	 *
	 * @param int $user_id ID of emoji owner
	 * @param Slim $app
	 * @return string
	 */
    public static function create($user_id, Slim $app)
    {
		$app->response->headers->set('Content-Type', 'application/json');
        Setup::setTimezone();

		$fields = $app->request->post();

		if (! empty($fields)) {
			$emoji = new Emoji;
			$emoji->user_id = $user_id;

			foreach ($fields as $key => $value) {
				$emoji->$key = $value;
			}

			$time = date("Y-m-d H:i:s");
			$emoji->date_created = $time;
			$emoji->date_modified = $time;
			$check = $emoji->save();

			if ($check === 1) {
				$emojiCreated = $emoji->where('emoji_name', $emoji->getRecord()['emoji_name'])->getRecord()['dbData'];

				return json_encode(Setup::format($emojiCreated));
			} else {
				$app->halt(503, json_encode(['message' => 'Confirm all fields have entry']));
			}
		} else {
			$app->halt(422, json_encode(['message' => 'All fields must have entry']));
		}
    }

	/**
	 * Update an emoji resource
	 *
	 * @param int $id ID of emoji owner
	 * @param Slim $app
	 * @return string
	 */
    public static function update($id, Slim $app)
    {
		$app->response->headers->set('Content-Type', 'application/json');

		try {
			$emoji = Emoji::find($id);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
		}

		if (is_object($emoji)) {
			Setup::setTimezone();

			$fields = $app->request->isPut() ? $app->request->put() : $app->request->patch();

			foreach ($fields as $key => $value) {
				$emoji->$key = $value;
			}

			$emoji->date_modified = date("Y-m-d H:i:s");
			$check = $emoji->save();

			if ($check === 1) {
				$emojiUpdated = $emoji->find($id)->getRecord()['dbData'];

				return json_encode(Setup::format($emojiUpdated));
			} else {
				$app->halt(304);
			}
		} else {
			$app->halt(503);
		}
    }

	/**
	 * Destroy an emoji resource
	 *
	 * @param int $id ID of emoji owner
	 * @param Slim $app
	 * @return string
	 */
    public static function delete($id, Slim $app)
    {
		$app->response->headers->set('Content-Type', 'application/json');

		try {
			$check = Emoji::destroy($id);
		} catch (RecordNotFoundException $e) {
			$app->halt(404, json_encode(['message' => 'Not Found']));
		}

		if ($check === 1) {
			return json_encode(['message' => 'Deleted']);
		} else {
			$app->halt(304);
		}
    }
}