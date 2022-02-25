<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address_fl".
 *
 * @property int $id
 * @property int|null $counterparty
 * @property int|null $type
 * @property string|null $index
 * @property string|null $country
 * @property string|null $region
 * @property string|null $district
 * @property string|null $city
 * @property string|null $locality
 * @property string|null $street
 * @property string|null $house
 * @property string|null $body
 * @property string|null $building
 * @property string|null $apartment
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class AddressFl extends \yii\db\ActiveRecord
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

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address_fl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            [['counterparty', 'type'], 'integer'],
            [['index', 'country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'apartment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'counterparty' => 'Counterparty',
            'type' => 'Type',
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
            'apartment' => 'Квартира',

            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активнен',
            self::STATUS_INACTIVE => 'Аннулирован',
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
