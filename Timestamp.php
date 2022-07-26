<?php

namespace davidhirtz\yii2\datetime;

/**
 * Date extends the default DateTime to return a timestamp on string.
 */
class Timestamp extends \DateTime
{
    /**
     * @return string the formatted UTC timestamp.
     */
    public function __toString()
    {
        return $this->getTimestamp();
    }
}