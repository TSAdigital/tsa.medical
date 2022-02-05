<?php

namespace app\components;

use yii\helpers\Html;
use yii\i18n\Formatter;

class FormatterHelper extends Formatter {

    public static function asSnils($value) {
        return preg_replace('#^(\d{3})(\d{3})(\d{3})(\d{2})$#', '$1-$2-$3 $4', $value);
    }

    public static function asPhone($value) {
        return Html::a(preg_replace('#^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$#', '$1($2)$3-$4-$5', $value), "tel:$value");
    }

    public static function asPassportSerial($value) {
        return preg_replace('#^(\d{2})(\d{2})$#', '$1 $2', $value);
    }

    public static function asPassportDepartmentCode($value) {
        return preg_replace('#^(\d{3})(\d{3})$#', '$1-$2', $value);
    }
}