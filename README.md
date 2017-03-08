# JWT Login
A small JWT demo for authentication
This should most likely not be used in any real world application.

## Setup

** You should always you HTTPS **

Install all php dependencies using `composer`.

Create a set of keys using the `jwt_create_keys` script.

Set the webserver root dir to the `httpdocs` folder.


### Configuration

Change the values inside of `lib/classes/Config.php` according to your setup.

DB-Schema:
```
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pwd` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8
```

## Usage

#### Register
Post a JSON with username and password to `register.php`

#### Login
Post a JSON with username and password to `login.php` and store the jwt from the response

#### Check
Post a JSON with the jwt to `check_session.php`

#### Logout
Just call `logout.php` and remove the jwt from your storage
Right now this isn't really a logout

## TODO

- Use cookies and just send and XSRF Token

- Create a whitelist to save the jti

- Make public key accessible for clients (validation)
