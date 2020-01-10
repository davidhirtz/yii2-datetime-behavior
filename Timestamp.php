<?php
/**
 * @author David Hirtz <hello@davidhirtz.com>
 * @copyright Copyright (c) 2020 David Hirtz
 * @version 1.1.3
 */

namespace davidhirtz\yii2\datetime;

/**
 * Class Timestamp.
 * @package davidhirtz\yii2\datetime
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