<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "passport".
 *
 * @property int $id
 * @property int|null $counterparty
 * @property string|null $passport_serial
 * @property string|null $passport_number
 * @property string|null $passport_date
 * @property string|null $passport_issued
 * @property string|null $passport_department_code
 * @property string|null $passport_birthplace
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Passport extends ActiveRecord
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
        return 'passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['counterparty', 'status', 'created_at', 'updated_at'], 'integer'],
            [['passport_date'], 'safe'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            [['passport_serial', 'passport_number', 'passport_issued', 'passport_department_code', 'passport_birthplace'], 'string', 'max' => 255],
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
            'passport_serial' => 'Серия',
            'passport_number' => 'Номер',
            'passport_date' => 'Дата выдачи',
            'passport_issued' => 'Кто выдал',
            'passport_department_code' => 'Код подразделения',
            'passport_birthplace' => 'Место рождения',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
