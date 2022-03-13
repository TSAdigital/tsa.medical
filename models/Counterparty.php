<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "counterpartie".
 *
 * @property int $id
 * @property string $name
 * @property string|null $full_name
 * @property string $inn
 * @property string|null $kpp
 * @property string|null $ogrn
 * @property string|null $okpo
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $web_site
 *
 * @property string|null $director_last_name
 * @property string|null $director_firs_name
 * @property string|null $director_middle_name
 * @property string|null $director_position
 * @property string|null $director_document
 *
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 *  * @property Position $position
 */
class Counterparty extends ActiveRecord
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
        return 'counterparty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['name', 'trim'],

            ['full_name', 'string', 'max' => 255],
            ['full_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['full_name', 'trim'],

            ['inn', 'unique'],
            ['inn', 'required'],
            ['inn', 'match', 'pattern' => '#^(\d{10,12})$#', 'message' => 'Значение «ИНН» должно содержать от 10 до 12 символов.'],
            ['inn', 'trim'],
            ['inn', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['kpp', 'match', 'pattern' => '#^(\d{9})$#', 'message' => 'Значение «КПП» должно содержать 9 символов.'],
            ['kpp', 'trim'],
            ['kpp', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['ogrn', 'match', 'pattern' => '#^(\d{13})$#', 'message' => 'Значение «ОГРН» должно содержать 13 символов.'],
            ['ogrn', 'trim'],
            ['ogrn', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['okpo', 'match', 'pattern' => '#^(\d{8,10})$#', 'message' => 'Значение «ОКПО» должно содержать от 8 до 10 символов.'],
            ['okpo', 'trim'],
            ['okpo', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['phone', 'match', 'pattern' => '#^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})|(\d{1})(\(\d{3}\))(\d{3})\s+(\d{2})\s+(\d{2})$#', 'message' => 'Значение «Номер телефона» должно содержать 11 символов.'],
            ['phone', 'trim'],
            ['phone', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['email', 'email'],
            ['email', 'trim'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['web_site', 'url', 'defaultScheme' => 'http'],
            ['director_last_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['director_last_name', 'trim'],

            ['director_last_name', 'string', 'max' => 40],
            ['director_last_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['director_last_name', 'trim'],

            ['director_firs_name', 'string', 'max' => 40],
            ['director_firs_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['director_firs_name', 'trim'],

            ['director_middle_name', 'string', 'max' => 40],
            ['director_middle_name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['director_middle_name', 'trim'],

            ['director_position', 'integer'],
            ['director_position', 'trim'],
            ['director_position', 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['director_position' => 'id']],
            ['director_position', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['director_document', 'string', 'max' => 255],
            ['director_document', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['director_document', 'trim'],

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
            'name' => 'Наименование',
            'full_name' => 'Полное наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'ogrn' => 'ОГРН',
            'okpo' => 'ОКПО',
            'director_last_name' => 'Фамилия',
            'director_firs_name' => 'Имя',
            'director_middle_name' => 'Отчество',
            'director_position' => 'Должность',
            'director_document' => 'Основание',
            'phone' => 'Номер телефона',
            'email' => 'Элетронная почта',
            'web_site' => 'Сайт',
            'contact_name' => 'Имя',
            'contact_position' => 'Должность',
            'contact_phone' => 'Номер телефона',
            'contact_phone_extension' => 'Внутренний номер телефона',
            'contact_email' => 'Электронная почта',
            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'director_position']);
    }

    public function getPositionName()
    {
        return isset($this->position->name) ? $this->position->name : null;
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
}
