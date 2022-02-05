<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property int $index
 * @property string $country
 * @property string $region
 * @property string $district
 * @property string $city
 * @property string $locality
 * @property string $street
 * @property string $house
 * @property string $body
 * @property string $building
 * @property string $office
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Department extends ActiveRecord
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['name', 'string', 'max' => 255],
            ['name', 'unique'],
            ['name', 'required'],
            ['name', 'trim'],
            ['name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['index', 'string', 'min' => 6, 'tooShort' => 'Значение «Индекс» должно содержать 6 символов.'],
            ['index', 'trim'],
            ['index', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['country', 'string', 'max' => 255],
            ['country', 'trim'],
            ['country', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['region', 'string', 'max' => 255],
            ['region', 'trim'],
            ['region', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['district', 'string', 'max' => 255],
            ['district', 'trim'],
            ['district', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['city', 'string', 'max' => 255],
            ['city', 'trim'],
            ['city', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['locality', 'string', 'max' => 255],
            ['locality', 'trim'],
            ['locality', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['street', 'string', 'max' => 255],
            ['street', 'trim'],
            ['street', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['house', 'string', 'max' => 255],
            ['house', 'trim'],
            ['house', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['body', 'string', 'max' => 255],
            ['body', 'trim'],
            ['body', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['building', 'string', 'max' => 255],
            ['building', 'trim'],
            ['building', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['office', 'string', 'max' => 255],
            ['office', 'trim'],
            ['office', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Наименование',
            'index' => 'Индекс',
            'country' => 'Страна',
            'region' => 'Регион',
            'district' => 'Район',
            'city' => 'Город',
            'locality' => 'Населенный пункт',
            'street' => 'Улица',
            'house' => 'Дом',
            'body' => 'Корпус',
            'building' => 'Строение',
            'office' => 'Офис',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_INACTIVE => 'Аннулировано',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public function setStatus($status)
    {
        ($status === 'STATUS_ACTIVE') ? $this->status = self::STATUS_ACTIVE : $this->status = self::STATUS_INACTIVE;
        if($this->save(true, ['status'])){
            return true;
        }
        return false;
    }
}
