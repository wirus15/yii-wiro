HASH Library
============

![HASH Library box](http://www.octolab.org/assets/img/libraries/HASHLibrary.png)

## About
Main purpose of the Library is **encapsulate** hashing mechanisms and **give** to them a convenient and simple interface of access:

```php
// give default strategy (task: HASH::COMMON, strategy: HASH::MD5)
$crypt = HASH::getInstance();

// give default strategy for password hashing (strategy: HASH::SHA1_MD5)
$crypt = HASH::getInstance(HASH::PASSWORD);

// give selected strategy for password hashing
$crypt = HASH::getInstance(HASH::PASSWORD, array(
	'strategy' => HASH::MD5_SALT_SHA1,		// some strategies require salt, by default $salt = substr(md5(__CLASS__), 0, 22)
	'salt' => $this->config->item('salt'),	// salt, for example, can be stored globally in the site settings
));
```


## Information
* [Official page](http://www.octolab.org/libraries/hash)
* You can read a useful [article](http://www.yiiframework.com/wiki/425/use-crypt-for-password-storage/) about using crypt() function for password storage (in particular about advantages of the [Blowfish algorithm](http://en.wikipedia.org/wiki/Blowfish_%28cipher%29) on Yii framework wiki pages



## Requirements
* PHP grater or equals than 5.3.0


## Preparation
Classes are connected via a **relative path**. And therefore you must add parent folder of the Library into include path:

```php
set_include_path(get_include_path() . PATH_SEPARATOR . 'path/to/folder/which/contains/HASH');
```


## Work with library
Hashing and comparing:

```php
$crypt = HASH::getInstance(HASH::PASSWORD);
$hash = $crypt->make($string);

if ($crypt->compare($input, $stored)) {
	echo 'Match';
} else {
	echo 'Do not match';
}
```

New feature in version 1.3:

```php
if ($crypt->isHashed($password)) {
	echo 'Is hashed';
} else {
	echo 'Is not hashed';
}
```


## Adapters
### Yii
Yii_Hash designed for handy integration the Library with [Yii framework](http://www.yiiframework.com/).

Setup configuration of the Library:

```php
Yii::setPathOfAlias('HASH', 'path/to/HASH'); // set namespace

return array(
	...,
	'components' => array(
		...,
		'hash' => array(
			'class' => 'HASH\adapters\Yii_Hash',
			'strategies' => array(
				'pass' => array(
					'strategy' => 17, // or HASH\HASH::BLOWFISH_RANDOM_SALT,
					'cost' => 12,
				),
			),
		),
	),
);
```

After that you can use it as usual component Yii:

```php
$hash = Yii::app()->hash->pass->make($input);

if (Yii::app()->hash->pass->compare($input, $stored)) {
	echo 'Match';
} else {
	echo 'Do not match';
}
```

Use new method iHash::isHashed() in ActiveRecord:

```php
class User extends CActiveRecord
{
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			/**
			 * @var iHash $crypt
			 */
			$crypt = Yii::app()->hash->pass;
			if ( ! $crypt->isHashed($this->password)) {
				$this->password = $crypt->make($this->password);
			}
			return true;
		}
		return false;
	}
}
```

### CodeIgniter
CI_Hash designed for handy integration the Library with [CodeIgniter framework](http://ellislab.com/codeigniter).

You can define configuration of the Library in hash.php file in config folder of CodeIgniter:

```php
$config = array(
	'pass' => array(
		'strategy' => HASH::SHA1_MD5_SALT,
		'salt' => 'q3XBgoiRCXfuTertfplXv1ICT',
	),
	'email' => array(
		'strategy' => HASH::MD5_SALT,
		'salt' => 'GswJNrMQAA_Q',
	),
);
```

Or you can put config into loader:

```php
$config = array(
	'pass' => array(
		'strategy' => HASH::SHA1_MD5_SALT,
		'salt' => 'q3XBgoiRCXfuTertfplXv1ICT',
	),
	'email' => array(
		'strategy' => HASH::MD5_SALT,
		'salt' => 'GswJNrMQAA_Q',
	),
);
$this->load->library('hash', $config);
```

After that you can use it as usual library for CodeIgniter:

```php
$hash = $this->hash->pass->make($input);

if ($this->hash->pass->compare($input, $stored)) {
	echo 'Match';
} else {
	echo 'Do not match';
}
```

### Silex
SLX_Hash designed for handy integration the Library with [Silex framework](http://silex.sensiolabs.org/).

Access to the Library implemented via ServiceProvider:

```php
use HASH\adapters\SLX_Hash as Hash;
$app->register(new Hash(), array(
	'hash.task' => HASH::SHA1_MD5_SALT,
	'hash.config' => array(
		'strategy' => HASH::SHA1_MD5_SALT,
		'salt' => 'q3XBgoiRCXfuTertfplXv1ICT',
	),
));
```

After that you can use it as usual service provider for Silex:

```php
$pass = 'hash_of_super_secret_pass';

$app->post('login', function (Application $app, Request $request) use ($pass) {
	$crypt = $app['hash'];
	if ($crypt->compare($request->get('pass'), $pass)) {
		echo 'Match';
	} else {
		echo 'Do not match';
	}
})
```


## Unit tests
All tests located at `tests` folder. You can run it as follows:

```
% phpunit StrategiesUnitTest
% phpunit ComponentUnitTest
```


## License

Copyright (c) HASH Library from OctoLab

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


## [Changelog](CHANGELOG.md)