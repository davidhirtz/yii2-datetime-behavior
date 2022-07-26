Yii2 DateTime Behavior
======================
Initiates database date columns as DateTime PHP classes.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist davidhirtz/yii2-datetime-behavior "*"
```

or add

```
"davidhirtz/yii2-datetime-behavior": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by adding it to your ActiveRecord behavior. If you don't set the attributes all "date" and "datetime" columns will be automatically selected.

```php
use davidhirtz\yii\datetime\DateTimeBehavior;
public function behaviors()
{
	return [
		[
			'class'=>DateTimeBehavior::class,
			//'attributes'=>['custom_attribute', 'another_attribute'],
		],
	];
}
```
