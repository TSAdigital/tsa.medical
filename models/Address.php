<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $counterparty_id
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
            [['counterparty_id', 'created_at', 'updated_at'], 'required'],
            [['counterparty_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['index', 'country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'office'], 'string', 'max' => 255],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
}
