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
 * @property string|null $director
 * @property string|null $director_document
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $web_site
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
 * @property string|null $contact_name
 * @property string|null $contact_position
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
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
            [['name', 'inn'], 'required'],

            [['name', 'full_name', 'inn', 'kpp', 'ogrn', 'okpo', 'director', 'director_document', 'phone', 'email', 'web_site', 'index', 'country', 'region', 'district', 'city', 'locality', 'street', 'house', 'body', 'building', 'office', 'contact_name', 'contact_position', 'contact_phone', 'contact_email'], 'string', 'max' => 255],
            [['inn'], 'unique'],

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
            'director' => 'Руководитель',
            'director_document' => 'Основание',
            'phone' => 'Номер телефона',
            'email' => 'Элетронная почта',
            'web_site' => 'Сайт',
            'index' => 'Индекс',
            'country' => 'Страна',
            'region' => 'Регион',
            'district' => 'Район',
            'city' => 'Город',
            'locality' => 'Населенный пункт',
            'street' => 'Улица',
            'house' => 'Дом',
            'body' => 'Корпус',
            'building' => 'Здание',
            'office' => 'Офис',
            'contact_name' => 'Имя',
            'contact_position' => 'Должность',
            'contact_phone' => 'Номер телефона',
            'contact_email' => 'Электронная почта',
            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
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
}
