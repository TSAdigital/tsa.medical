<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $counterparty_id
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
 * @property string|null $office
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Counterparty $counterparty
 */
class Address extends ActiveRecord
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const ADDRESS_POSTAL = 8;
    const ADDRESS_REGISTRATION = 9;
    const ADDRESS_ACTUAL = 10;

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
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'office'], 'string', 'max' => 255],
            [['country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'office'], 'trim'],
            [['country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'office'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['index', 'match', 'pattern' => '#^(\d{6})$#', 'message' => 'Значение «Индекс» должно содержать 6 символов.'],
            ['index', 'trim'],
            ['index', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['counterparty_id', 'integer'],
            ['counterparty_id', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],
            [['counterparty_id'], 'required'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            ['type', 'required'],
            ['type', 'default', 'value' => self::ADDRESS_ACTUAL],
            ['type', 'in', 'range' => [self::ADDRESS_REGISTRATION, self::ADDRESS_POSTAL, self::ADDRESS_ACTUAL]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'counterparty_id' => 'Counterparty ID',
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
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    /**
     * Gets query for [[Counterparty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounterparty()
    {
        return $this->hasOne(Counterparty::className(), ['id' => 'counterparty_id']);
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_INACTIVE => 'Аннулирована',
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

    public static function getAddressesArray()
    {
        return [
            self::ADDRESS_REGISTRATION=> 'Юридический',
            self::ADDRESS_ACTUAL => 'Фактический',
            self::ADDRESS_POSTAL => 'Почтовый',
        ];
    }

    public function getAddressName()
    {
        return ArrayHelper::getValue(self::getAddressesArray(), $this->type);
    }
}
