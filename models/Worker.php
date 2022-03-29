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
 * @property int $counterparty_id
 * @property int|null $position_id
 * @property int $department_id
 * @property int|null $division_id
 * @property string|null $document
 * @property string|null $document_number
 * @property string|null $document_date
 * @property string|null $start_work
 * @property string|null $end_work
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CounterpartyFl $counterparty
 * @property Department $department
 * @property Division $division
 * @property Position $position
 */
class Worker extends ActiveRecord
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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            ['counterparty_id', 'required'],
            ['counterparty_id', 'integer'],
            ['counterparty_id', 'exist', 'skipOnError' => true, 'targetClass' => CounterpartyFl::className(), 'targetAttribute' => ['counterparty_id' => 'id']],

            ['department_id', 'required'],
            ['department_id', 'integer'],
            ['department_id', 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],

            ['division_id', 'integer'],
            ['division_id', 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division_id' => 'id']],

            ['position_id', 'integer'],
            ['position_id', 'required'],
            ['position_id', 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],

            ['document', 'string', 'max' => 255],
            ['document', 'trim'],
            ['document', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['document_number', 'string', 'max' => 255],
            ['document_number', 'trim'],
            ['document_number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['document_date', 'date'],

            ['start_work', 'date'],

            ['end_work', 'date'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'counterparty_id' => 'Контрагент',
            'counterparty_name' => 'Контрагент',
            'position_id' => 'Должность',
            'position_name' => 'Должность',
            'department_id' => 'Подразделение',
            'department_name' => 'Подразделение',
            'division_id' => 'Отделение',
            'division_name' => 'Отделение',
            'document' => 'Основание',
            'document_number' => 'Номер документа',
            'document_date' => 'Дата документа',
            'start_work' => 'Дата выхода на работу',
            'end_work' => 'Дата окончания работы',

            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    /**
     * Gets query for [[Counterparty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounterparty()
    {
        return $this->hasOne(CounterpartyFl::className(), ['id' => 'counterparty_id']);
    }

    public function getCounterparty_name()
    {
        return $this->counterparty->getFullName();
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public function getDepartment_name()
    {
        return $this->department->name;
    }

    /**
     * Gets query for [[Division]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'division_id']);
    }

    public function getDivision_name()
    {
        return !empty($this->division->name) ? $this->division->name : NULL;
    }


    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    public function getPosition_name()
    {
        return $this->position->name;
    }


    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_INACTIVE => 'Аннулирована',
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
        $this->document_date= !empty($this->document_date) ? date('Y-m-d', strtotime($this->document_date)) : null;
        $this->start_work = !empty($this->start_work) ? date('Y-m-d', strtotime($this->start_work)) : null;
        $this->end_work = !empty($this->end_work) ? date('Y-m-d', strtotime($this->end_work)) : null;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind ();
        $this->document_date = !empty($this->document_date) ? Yii::$app->formatter->asDate($this->document_date) : null;
        $this->start_work = !empty($this->start_work) ? Yii::$app->formatter->asDate($this->start_work) : null;
        $this->end_work = !empty($this->end_work) ? Yii::$app->formatter->asDate($this->end_work) : null;
    }
}
