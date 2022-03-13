<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property int $counterparty_id
 * @property string|null $name
 * @property int|null $position
 * @property string|null $phone
 * @property string|null $phone_extension
 * @property string|null $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Counterparty $counterparty
 */
class Contact extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['counterparty_id', 'created_at', 'updated_at'], 'required'],
            [['counterparty_id', 'position', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'phone', 'phone_extension', 'email'], 'string', 'max' => 255],
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
            'name' => 'Имя',
            'position' => 'Должность',
            'phone' => 'Номер телефона',
            'phone_extension' => 'Внутренний номер',
            'email' => 'Email',
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
