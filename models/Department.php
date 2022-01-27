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
 * @property string $city
 * @property string $street
 * @property string $building
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

            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'required'],

            [['index'], 'integer'],

            [['country'], 'string', 'max' => 255],

            [['region'], 'string', 'max' => 255],

            [['city'], 'string', 'max' => 255],

            [['street'], 'string', 'max' => 255],

            [['building'], 'string', 'max' => 255],

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
            'city' => 'Город',
            'street' => 'Улица',
            'building' => 'Строение',
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
