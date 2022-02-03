<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "division".
 *
 * @property int $id
 * @property int $department
 * @property string $name
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Department $department0
 */
class Division extends ActiveRecord
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
    public static function tableName()
    {
        return 'division';
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
            ['department', 'required'],
            ['department', 'integer'],
            ['department', 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department' => 'id']],

            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['name', 'trim'],

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
            'id' => 'Идентификатор',
            'department' => 'Подразделение',
            'department_name' => 'Подразделение',
            'name' => 'Наименование',
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

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_INACTIVE => 'Аннулировано',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public function getDepartment_name()
    {
        return $this->department0->name;
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
