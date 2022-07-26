<?php

namespace davidhirtz\yii2\datetime;

/**
 * Date extends the default DateTime object by returning a MySQL-conform date string.
 */
class Date extends \DateTime
{
    /**
     * @return string the formatted UTC date string.
     */
    public function __toString()
    {
        return gmdate('Y-m-d', $this->getTimestamp());
    }
}