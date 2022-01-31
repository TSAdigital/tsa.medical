<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "worker".
 *
 * @property int $id
 * @property int $department
 * @property string $last_name
 * @property string $firs_name
 * @property string $middle_name
 * @property string $birthdate
 * @property int $gender
 * @property int $snils
 * @property int|null $inn
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Department $department0
 *
 * @property integer $passport_serial
 * @property integer $passport_number
 * @property string $passport_date
 * @property string $passport_issued
 * @property integer $passport_department_code
 * @property string $passport_birthplace
 *
 * @property integer $address_index
 * @property string $address_country
 * @property string $address_region
 * @property string $address_district
 * @property string $address_city
 * @property string $address_locality
 * @property string $address_street
 * @property string $address_house
 * @property string $address_body
 * @property string $address_building
 * @property string $address_apartment
 */

class Worker extends ActiveRecord
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const GENDER_MALE = 9;
    const GENDER_FEMALE = 10;

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
        return 'worker';
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
            [['department', 'last_name', 'firs_name', 'birthdate', 'gender', 'snils',], 'required'],
            [['department', 'gender', 'snils', 'inn', 'status', 'created_at', 'updated_at'], 'integer'],
            [['birthdate'], 'safe'],
            [['last_name', 'firs_name', 'middle_name'], 'string', 'max' => 255],
            [['snils'], 'unique'],
            [['department'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department' => 'id']],

            ['passport_serial', 'integer'],
            ['passport_number', 'integer'],
            ['passport_date', 'string'],
            ['passport_issued', 'string'],
            ['passport_department_code', 'integer'],
            ['passport_birthplace', 'string'],

            ['address_index', 'integer'],
            ['address_index', 'trim'],
            ['address_index', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_country', 'string', 'max' => 255],
            ['address_country', 'trim'],
            ['address_country', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_region', 'string', 'max' => 255],
            ['address_region', 'trim'],
            ['address_region', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_district', 'string', 'max' => 255],
            ['address_district', 'trim'],
            ['address_district', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_city', 'string', 'max' => 255],
            ['address_city', 'trim'],
            ['address_city', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_locality', 'string', 'max' => 255],
            ['address_locality', 'trim'],
            ['address_locality', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_street', 'string', 'max' => 255],
            ['address_street', 'trim'],
            ['address_street', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_house', 'string', 'max' => 255],
            ['address_house', 'trim'],
            ['address_house', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_body', 'string', 'max' => 255],
            ['address_body', 'trim'],
            ['address_body', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_building', 'string', 'max' => 255],
            ['address_building', 'trim'],
            ['address_building', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_apartment', 'string', 'max' => 255],
            ['address_apartment', 'trim'],
            ['address_apartment', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['work_position', 'integer'],

            ['work_document', 'string', 'max' => 255],
            ['work_document', 'trim'],
            ['work_document', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['work_document_number', 'string', 'max' => 255],
            ['work_document_number', 'trim'],
            ['work_document_number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['work_document_date', 'integer'],

            ['work_start', 'integer'],

            ['work_end', 'integer'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department' => 'Подразделение',
            'department_name' => 'Подразделение',
            'last_name' => 'Фамилия',
            'firs_name' => 'Имя',
            'middle_name' => 'Отчество',
            'birthdate' => 'Дата рождения',
            'gender' => 'Пол',
            'snils' => 'СНИЛС',
            'inn' => 'ИНН',

            'passport_serial' => 'Серия',
            'passport_number' => 'Номер',
            'passport_date' => 'Дата выдачи',
            'passport_issued' => 'Паспорт выдан',
            'passport_department_code' => 'Код подразделения',
            'passport_birthplace' => 'Место рождения',

            'address_index' => 'Индекс',
            'address_country' => 'Страна',
            'address_region' => 'Регион',
            'address_district' => 'Район',
            'address_city' => 'Город',
            'address_locality' => 'Населенный пункт',
            'address_street' => 'Улица',
            'address_house' => 'Дом',
            'address_body' => 'Корпус',
            'address_building' => 'Строение',
            'address_apartment' => 'Квартира',

            'work_position' => 'Должность',
            'work_document' => 'Документ',
            'work_document_number' => 'Номер документа',
            'work_document_date' => 'Дата документа',
            'work_start' => 'Начало работы',
            'work_end' => 'Конец работы',

            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    /**
     * Gets query for [[Department0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment0()
    {
        return $this->hasOne(Department::className(), ['id' => 'department']);
    }

    public function getDepartment_name()
    {
        return $this->department0->name;
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активнен',
            self::STATUS_INACTIVE => 'Аннулирован',
        ];
    }

    public static function getGenderArray()
    {
        return [
            self::GENDER_MALE => 'Мужской',
            self::GENDER_FEMALE => 'Женский',
        ];
    }

    public function getGender()
    {
        return ArrayHelper::getValue(self::getGenderArray(), $this->gender);
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
        $this->birthdate = date('Y-m-d', strtotime($this->birthdate));
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind ();
        $this->birthdate = Yii::$app->formatter->asDate($this->birthdate);
   }
}
