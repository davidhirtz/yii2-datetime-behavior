<?php
/**
 * @author David Hirtz <hello@davidhirtz.com>
 * @copyright Copyright (c) 2015 David Hirtz
 * @version 1.0.2
 */
namespace davidhirtz\yii2\datetime;
use Yii;

/**
 * Class DateTimeValidator.
 * @package app\components\validators
 */
class DateTimeValidator extends \yii\validators\Validator
{
	/**
	 * @var string
	 */
	public $dateClass;

	/**
	 * @var string
	 */
	public $timeZone;

	/**
	 * Sets default values.
	 */
	public function init()
	{
		if($this->message===null)
		{
			$this->message=Yii::t('yii', 'The format of {attribute} is invalid.');
		}

		if($this->timeZone===null)
		{
			$this->timeZone=Yii::$app->getTimeZone();
		}

		if(!$this->dateClass)
		{
			$this->dateClass='\davidhirtz\yii2\datetime\DateTime';
		}

		parent::init();
	}

	/**
	 * Validates DateTime.
	 * @param \yii\db\ActiveRecord $model
	 * @param string $attribute
	 */
	public function validateAttribute($model, $attribute)
	{
		if(!$model->getAttribute($attribute) instanceof $this->dateClass)
		{
			try
			{
				$model->setAttribute($attribute, @new $this->dateClass($model->getAttribute($attribute), new \DateTimeZone($this->timeZone)));
			}
			catch(\Exception $ex)
			{
				$this->addError($model, $attribute, $this->message);
			}
		}
	}
}