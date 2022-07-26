<?php

namespace davidhirtz\yii2\datetime;

/**
 * Date extends the default DateTime object by returning a MySQL-conform datetime string.
 */
class DateTime extends \DateTime
{
    /**
     * @return string the formatted UTC datetime string.
     */
    public function __toString()
    {
        return gmdate('Y-m-d H:i:s', $this->getTimestamp());
    }
}