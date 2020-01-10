<?php
/**
 * @author David Hirtz <hello@davidhirtz.com>
 * @copyright Copyright (c) 2020 David Hirtz
 * @version 1.1.3
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
     * @var \DateTime|string
     */
    public $dateClass;

    /**
     * @var DateTimeZone|string
     */
    public $timezone;

    /**
     * Sets default values.
     */
    public function init()
    {
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The format of {attribute} is invalid.');
        }

        if (!$this->timezone || is_string($this->timezone)) {
            $this->timezone = new DateTimeZone($this->timezone ?: Yii::$app->getTimeZone());
        }

        if (!$this->dateClass) {
            $this->dateClass = '\davidhirtz\yii2\datetime\DateTime';
        }

        parent::init();
    }

    /**
     * Validates DateTime.
     *
     * @param \yii\db\ActiveRecord $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$model->{$attribute} instanceof $this->dateClass) {
            try {
                // Replace European date dd.mm.yy with US mm/dd/yy
                $model->{$attribute} = @new $this->dateClass(preg_replace_callback('#^(\d{1,2})\.(\d{1,2})\.?(\d{0,4})#', function ($matches) {
                    return $matches[2] . '/' . $matches[1] . '/' . ($matches[3] ?: date('Y'));
                }, $model->{$attribute}), $this->timezone);

            } catch (\Exception $ex) {
                $this->addError($model, $attribute, $this->message);
            }
        }
    }
}