# emoji-RESTful-api

[![Build Status](https://travis-ci.org/andela-kerinoso/emoji-RESTful-api.svg?branch=master)](https://travis-ci.org/andela-kerinoso/emoji-RESTful-api)

A RESTful API for emoji storage and management. This API is managed by a simple but secured token-based authentication. Enjoy using [naijamoji](http://naijamoji.herokuapp.com/)

## Installation

[PHP](https://php.net) 5.5+ and [Composer](https://getcomposer.org) are required.

Via Composer

$ composer require kola/emoji-restful-api
```

``` bash
$ composer install
```

## Usage

Visit [naijamoji](http://naijamoji.herokuapp.com/).

## Methods accessible to the public

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

* Login authentication
REQUEST:
``` bash
POST https://naijamoji.herokuapp.com/auth/login
HEADER: {"Content-Type": "application/json"}
BODY:
{
  "username": your_username,
  "password": your_password
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "username": "ogeni1",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
```

## Private Methods (Registration required)

* Registration
REQUEST:
``` bash
POST https://naijamoji.herokuapp.com/register
HEADER: {"Content-Type": "application/json"}
BODY:
{
  "username": your_preferred_username,
  "password": your_preferred_password,
  "password1": confirmation_of_your_preferred_password,
  "purpose": your_purpose_for_registration
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "username": "ogeni",
  "message": "Registration Complete! Go ahead and login to get a token."
}
```

* Logout
REQUEST:
``` bash
GET https://naijamoji.herokuapp.com/auth/logout
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "message": "Logged out"
}

* Posting of emojis
REQUEST:
``` bash
POST https://naijamoji.herokuapp.com/emojis
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
BODY:
{
  "emoji_name": "ojuju calabar",
  "emoji_char": "👹",
  "category": "festival",
  "keyword": "masquerade eegun ojuju_calabar"
}
```
RESPONSE:
```bash
HEADER: {"status": 200}
BODY:
{
  "id": 20,
  "user_id": 14,
  "emoji_name": "ojuju calabar",
  "emoji_char": "👹",
  "keyword": [
    "masquerade",
    "eegun",
    "ojuju_calabar"
  ],
  "category": "festival",
  "date_created": "2015-10-28 11:19:53",
  "date_modified": "2015-10-28 11:19:53"
}
```

* Updating emojis
REQUEST:
``` bash
PUT https://naijamoji.herokuapp.com/emojis/20
PATCH https://naijamoji.herokuapp.com/emojis/20
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
BODY:
{
  "category": "scary"
}
```
RESPONSE:
```bash
HEADER: {"status": 200}
BODY:
{
  "id": 20,
  "user_id": 14,
  "emoji_name": "ojuju calabar",
  "emoji_char": "👹",
  "keyword": [
    "masquerade",
    "eegun",
    "ojuju_calabar"
  ],
  "category": "scary",
  "date_created": "2015-10-28 11:19:53",
  "date_modified": "2015-10-28 11:27:30"
}
```

* Deletion of emojis
REQUEST:
```bash
DELETE https://naijamoji.herokuapp.com/emojis/20
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "message": "Deleted"
}
```

* Change of user's password
REQUEST:
``` bash
PATCH https://naijamoji.herokuapp.com/user/your_username
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
BODY:
{
  "username": "your_username",
  "password": "your_password",
  "passwordNew": "your_new_password"
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "message": "Password Updated"
}

* Deletion of one's account
REQUEST:
``` bash
DELETE https://naijamoji.herokuapp.com/user/your_username
HEADER:
{
  "Content-Type": "application/json",
  "Authorization": "dff6e05687698b9a7b4dc7ed32bef67d"
}
BODY:
{
  "username": "your_username",
  "password": "your_password"
}
```
RESPONSE:
``` bash
HEADER: {"status": 200}
BODY:
{
  "message": "Account Deleted"
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
