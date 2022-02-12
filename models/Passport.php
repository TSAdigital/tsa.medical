<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
            'passport_serial' => 'Passport Serial',
            'passport_number' => 'Passport Number',
            'passport_date' => 'Passport Date',
            'passport_issued' => 'Passport Issued',
            'passport_department_code' => 'Passport Department Code',
            'passport_birthplace' => 'Passport Birthplace',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
