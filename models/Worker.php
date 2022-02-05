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
 * @property int $division
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
 * @property Division $division0
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
            ['gender', 'required'],
            ['gender', 'integer'],
            ['gender', 'in', 'range' => [self::GENDER_FEMALE, self::GENDER_MALE]],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            ['department', 'required'],
            ['department', 'integer'],
            ['department', 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department' => 'id']],

            ['division', 'integer'],
            ['division', 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division' => 'id']],

            ['last_name', 'required'],
            ['last_name', 'string', 'max' => 40],
            ['last_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['last_name', 'trim'],

            ['firs_name', 'required'],
            ['firs_name', 'string', 'max' => 40],
            ['firs_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['firs_name', 'trim'],

            ['middle_name', 'string', 'max' => 40],
            ['middle_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['middle_name', 'trim'],

            ['birthdate', 'date'],
            ['birthdate', 'required'],

            ['snils', 'required'],
            ['snils', 'string', 'min' => 11, 'tooShort' => 'Значение «СНИЛС» должно содержать 11 символов.'],
            ['snils', 'unique'],
            ['snils', 'trim'],
            ['snils', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['inn', 'string', 'min' => 12, 'tooShort' => 'Значение «ИНН» должно содержать 12 символов.'],
            ['inn', 'trim'],
            ['inn', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['passport_serial', 'string', 'min' => 4, 'tooShort' => 'Значение «Серия» должно содержать 4 символа.'],
            ['passport_serial', 'trim'],
            ['passport_serial', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['passport_number', 'string', 'min' => 6, 'tooShort' => 'Значение «Номер» должно содержать 6 символов.'],
            ['passport_number', 'trim'],
            ['passport_number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['passport_date', 'date'],

            ['passport_issued', 'string'],
            ['passport_issued', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['passport_department_code', 'string', 'min' => 6, 'tooShort' => 'Значение «Код подразделения» должно содержать 6 символов.'],
            ['passport_department_code', 'trim'],
            ['passport_department_code', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['passport_birthplace', 'string', 'max' => 255],
            ['address_country', 'trim'],
            ['passport_birthplace', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['address_index', 'string', 'min' => 6, 'tooShort' => 'Значение «Индекс» должно содержать 6 символов.'],
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
            ['work_position', 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['work_position' => 'id']],

            ['work_document', 'string', 'max' => 255],
            ['work_document', 'trim'],
            ['work_document', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['work_document_number', 'string', 'max' => 255],
            ['work_document_number', 'trim'],
            ['work_document_number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['work_document_date', 'date'],

            ['work_start', 'date'],

            ['work_end', 'date'],
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
            'division' => 'Отделение',
            'division_name' => 'Отделение',
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
            'passport_issued' => 'Выдан',
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
            'position_name' => 'Должность',
            'work_document' => 'Основание',
            'work_document_number' => 'Номер документа',
            'work_document_date' => 'Дата документа',
            'work_start' => 'Дата выхода на работу',
            'work_end' => 'Дата окончания работы',

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

    public function getDivision0()
    {
        return $this->hasOne(Division::className(), ['id' => 'division']);
    }

    public function getDivision_name()
    {
        return $this->division0->name;
    }

    public function getPosition0()
    {
        return $this->hasOne(Position::className(), ['id' => 'work_position']);
    }

    public function getPosition_name()
    {
        return $this->position0->name;
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
        $this->passport_date = !empty($this->passport_date) ? date('Y-m-d', strtotime($this->passport_date)) : null;
        $this->work_document_date= !empty($this->work_document_date) ? date('Y-m-d', strtotime($this->work_document_date)) : null;
        $this->work_start = !empty($this->work_start) ? date('Y-m-d', strtotime($this->work_start)) : null;
        $this->work_end = !empty($this->work_end) ? date('Y-m-d', strtotime($this->work_end)) : null;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind ();
        $this->birthdate = Yii::$app->formatter->asDate($this->birthdate);
        $this->passport_date = !empty($this->passport_date) ? Yii::$app->formatter->asDate($this->passport_date) : null;
        $this->work_document_date= !empty($this->work_document_date) ? Yii::$app->formatter->asDate($this->work_document_date) : null;
        $this->work_start = !empty($this->work_start) ? Yii::$app->formatter->asDate($this->work_start) : null;
        $this->work_end = !empty($this->work_end) ? Yii::$app->formatter->asDate($this->work_end) : null;
   }
}
