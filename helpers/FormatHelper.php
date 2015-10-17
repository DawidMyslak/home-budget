<?php

namespace app\helpers;

use Yii;

class FormatHelper
{
    /**
     * @return float
     */
    public static function number($number) {
        return number_format((float)$number, 2, '.', '');
    }
}
