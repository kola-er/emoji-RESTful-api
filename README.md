# emoji-RESTful-api

[![Build Status](https://travis-ci.org/andela-kerinoso/emoji-RESTful-api.svg?branch=master)](https://travis-ci.org/andela-kerinoso/emoji-RESTful-api)

A RESTful API for emoji storage and management. This API is managed by a simple but secured token-based authentication. Enjoy using [naijamoji](http://naijamoji.herokuapp.com/)

## Installation

[PHP](https://php.net) 5.5+ and [Composer](https://getcomposer.org) are required.

Via Composer

``` bash
$ composer require kola/emoji-restful-api
```

``` bash
$ composer install
```

## Usage

Visit [naijamoji](http://naijamoji.herokuapp.com/).

> Methods accessible to the public

* Single emoji retrieval

REQUEST:
``` bash
GET https://naijamoji.herokuapp.com/emoji/3
HEADER: {"Content-Type": "application/json"}
```
RESPONSE: If resource 3 exist, the response should be:
``` bash
HEADER: {"status": 200}
BODY:
{
  "id": 3,
  "user_id": 1,
  "emoji_name": "aunty",
  "emoji_char": "🙋",
  "keyword": [
    "aunty",
    "sister",
    "egbon",
    "ma"
  ],
  "category": "respect",
  "date_created": "2015-10-19 22:37:08",
  "date_modified": "2015-10-19 22:37:08"
}
```
Else the response would be:
``` bash
HEADER: {"status": 404}
BODY:
{
  "message": "Not Found"
}
```

* All emojis retrieval

REQUEST:
``` php
HEADER: GET https://naijamoji.herokuapp.com/emojis
BODY: If there are saved resources
[
  {
    "id": 3,
    "user_id": 1,
    "emoji_name": "aunty",
    "emoji_char": "🙋",
    "keyword": [
      "aunty",
      "sister",
      "egbon",
      "ma"
    ],
    "category": "respect",
    "date_created": "2015-10-19 22:37:08",
    "date_modified": "2015-10-19 22:37:08"
  },
  {
    "id": 4,
    "user_id": 1,
    "emoji_name": "chop_knuckle",
    "emoji_char": "👊",
    "keyword": [
      "gbasibe",
      "chop_knuckle",
      "take_am"
    ],
    "category": "greeting",
    "date_created": "2015-10-19 22:42:08",
    "date_modified": "2015-10-19 22:42:08"
  },
  {
    "id": 5,
    "user_id": 1,
    "emoji_name": "olorun maje",
    "emoji_char": "🙅",
    "keyword": [
      "olorun_maje",
      "i_reject_it",
      "no_way"
    ],
    "category": "rejection",
    "date_created": "2015-10-19 22:44:50",
    "date_modified": "2015-10-19 22:44:50"
  }
]
```
Else the response would be:
``` bash
HEADER: {"status": 404}
BODY:
{
  "message": "Not Found"
}
```

## Change log

Please check out [CHANGELOG](CHANGELOG.md) file for information on what has changed recently.

## Contributing

Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits

emoji-RESTful-api is maintained by `Kolawole ERINOSO`.

## License

emoji-RESTful-api is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for details.
