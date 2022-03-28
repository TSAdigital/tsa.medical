<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "counterparty_fl".
 *
 * @property int $id
 * @property string $last_name
 * @property string $firs_name
 * @property string|null $middle_name
 * @property string $birthdate
 * @property int $gender
 * @property string $snils
 * @property string $phone
 * @property string $email
 * @property string|null $inn
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class CounterpartyFl extends ActiveRecord
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
        return 'counterparty_fl';
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

            ['birthdate', 'date'],
            ['birthdate', 'required'],

            ['snils', 'required'],
            ['snils', 'match', 'pattern' => '#^(\d{3})(\d{3})(\d{3})(\d{2})|(\d{3})-(\d{3})-(\d{3})\s+(\d{2})$#', 'message' => 'Значение «СНИЛС» должно содержать 11 символов.'],
            ['snils', 'unique'],
            ['snils', 'trim'],
            ['snils', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['phone', 'match', 'pattern' => '#^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})|(\d{1})(\(\d{3}\))(\d{3})\s+(\d{2})\s+(\d{2})$#', 'message' => 'Значение «Номер телефона» должно содержать 11 символов.'],
            ['phone', 'unique'],
            ['phone', 'trim'],
            ['phone', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['email', 'email'],
            ['email', 'unique'],
            ['email', 'trim'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['inn', 'match', 'pattern' => '#^(\d{12})$#', 'message' => 'Значение «ИНН» должно содержать 12 символов.'],
            ['inn', 'trim'],
            ['inn', 'unique'],
            ['inn', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Фамилия',
            'firs_name' => 'Имя',
            'middle_name' => 'Отчество',
            'birthdate' => 'Дата рождения',
            'gender' => 'Пол',
            'snils' => 'СНИЛС',
            'inn' => 'ИНН',
            'status' => 'Статус',
            'phone' => 'Номер телефона',
            'email' => 'Адрес электронной почты',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_INACTIVE => 'Аннулирована',
        ];
    }

    public static function getGenderArray()
    {
        return [
            self::GENDER_MALE => 'Мужской',
            self::GENDER_FEMALE => 'Женский',
        ];
    }

    public function setStatus($status)
    {
        ($status === 'STATUS_ACTIVE') ? $this->status = self::STATUS_ACTIVE : $this->status = self::STATUS_INACTIVE;
        if($this->save(true, ['status'])){
            return true;
        }
        return false;
    }

    public function getGender()
    {
        return ArrayHelper::getValue(self::getGenderArray(), $this->gender);
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
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
