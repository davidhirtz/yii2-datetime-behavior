<?php

namespace davidhirtz\yii2\datetime;

use DateTime;
use DateTimeZone;
use Yii;
use yii\db\ActiveRecord;

/**
 * DateTimeValidator checks if the attribute value is a valid date.
 */
class DateTimeValidator extends \yii\validators\Validator
{
    /**
     * @var DateTime|string
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
                $datetime = $this->formatDateTime($model->{$attribute});
                $model->{$attribute} = @new $this->dateClass($datetime, $this->timezone);
            } catch (\Exception $ex) {
                $this->addError($model, $attribute, $this->message);
            }
        }

        // If the date hasn't changed, set the attribute to the old record so it passes Yii's `isAttributeChanged`
        // method which requires the DateTime objects to be identical and thus will not be updated on save.
        if ($model instanceof ActiveRecord && $model->{$attribute} == $model->getOldAttribute($attribute)) {
            $model->{$attribute} = $model->getOldAttribute($attribute);
        }
    }

    /**
     * Replaces European date format dd.mm.yy with US mm/dd/yy and joins array values from {@link DateTimeInput} to
     * date string.
     *
     * @param string|array $datetime
     * @return string|string[]|null
     */
    protected function formatDateTime($datetime)
    {
        if (isset($datetime['date'], $datetime['time'])) {
            $datetime = "{$datetime['date']} {$datetime['time']}";
        }

        return preg_replace_callback('#^(\d{1,2})\.(\d{1,2})\.?(\d{0,4})#', function ($matches) {
            return $matches[2] . '/' . $matches[1] . '/' . ($matches[3] ?: date('Y'));
        }, $datetime);
    }
}