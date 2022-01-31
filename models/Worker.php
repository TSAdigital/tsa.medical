<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
 */
class Worker extends \yii\db\ActiveRecord
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
