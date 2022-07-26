<?php

namespace davidhirtz\yii2\datetime;

use DateTime;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Renders date and time input fields for given attribute.
 */
class DateTimeInput extends InputWidget
{
    /**
     * @var string[]
     */
    public $options = [
        'class' => 'form-control',
    ];

    /**
     * @var string the HTML wrapper for the date and time inputs
     */
    public $template = "<div class=\"row no-gutters\"><div class=\"col-6\">{date}</div><div class=\"col-6\">{time}</div></div>";

    /**
     * Renders the input fields in template.
     */
    public function run()
    {
        $dateTime = $this->hasModel() ? $this->model->{$this->attribute} : $this->value;
        $name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->name;

        $options = $this->options;
        $options['required'] = $options['required'] ?? ($this->hasModel() && $this->model->isAttributeRequired($this->attribute));

        $dateInput = Html::input('date', "{$name}[date]", $dateTime instanceof DateTime ? $dateTime->format('Y-m-d') : null, $options);
        $timeInput = Html::input('time', "{$name}[time]", $dateTime instanceof DateTime ? $dateTime->format('H:i') : null, $options);

        echo strtr($this->template, [
            '{date}' => $dateInput,
            '{time}' => $timeInput,
        ]);
    }
}