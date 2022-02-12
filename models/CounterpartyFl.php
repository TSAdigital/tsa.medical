<?php

namespace app\models;

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

            [['last_name', 'firs_name', 'birthdate', 'gender', 'snils'], 'required'],
            [['birthdate'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['last_name', 'firs_name', 'middle_name', 'snils', 'inn'], 'string', 'max' => 255],
            [['snils'], 'unique'],
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
}
