<?php

namespace app\models;

use Yii;
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
            [['counterparty'], 'integer'],

            ['passport_serial', 'string', 'min' => 4, 'tooShort' => 'Значение «Серия» должно содержать 4 символа.'],
            ['passport_serial', 'trim'],
            ['passport_serial', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['passport_serial', 'required'],

            ['passport_number', 'string', 'min' => 6, 'tooShort' => 'Значение «Номер» должно содержать 6 символов.'],
            ['passport_number', 'trim'],
            ['passport_number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['passport_number', 'required'],

            ['passport_date', 'date'],
            ['passport_date', 'required'],

            ['passport_issued', 'string'],
            ['passport_issued', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['passport_issued', 'required'],

            ['passport_department_code', 'string', 'min' => 6, 'tooShort' => 'Значение «Код подразделения» должно содержать 6 символов.'],
            ['passport_department_code', 'trim'],
            ['passport_department_code', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['passport_department_code', 'required'],

            ['passport_birthplace', 'string', 'max' => 255],
            ['passport_birthplace', 'trim'],
            ['passport_birthplace', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['passport_birthplace', 'required'],

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

    public function beforeSave($insert)
    {
        $this->passport_date = date('Y-m-d', strtotime($this->passport_date));

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind ();
        $this->passport_date = Yii::$app->formatter->asDate($this->passport_date);
    }

}
