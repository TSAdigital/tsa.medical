<?php

namespace app\models;



use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "certificate".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $counterparty_id
 * @property int $specialization_id
 * @property string|null $serial
 * @property string|null $number
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Specialization $specialization
 * @property Worker $worker
 * @property Counterparty $counterparty
 */
class Certificate extends ActiveRecord
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

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
        return 'certificate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['worker_id', 'required'],
            ['worker_id', 'integer'],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::className(), 'targetAttribute' => ['worker_id' => 'id']],

            ['counterparty_id', 'required'],
            ['counterparty_id', 'integer'],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],

            ['specialization_id', 'required'],
            ['specialization_id', 'integer'],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialization::className(), 'targetAttribute' => ['specialization_id' => 'id']],


            ['serial', 'string', 'max' => 255],
            ['serial', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['serial', 'trim'],

            ['number', 'string', 'max' => 255],
            ['number', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['number', 'trim'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            [['start_date', 'end_date'], 'date'],
            [['start_date', 'end_date'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => 'Worker ID',
            'counterparty_id' => 'Кем выдан',
            'specialization_id' => 'Специальность',
            'serial' => 'Серия',
            'number' => 'Номер',
            'start_date' => 'Дата выдачи',
            'end_date' => 'Срок действия',
            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(Specialization::className(), ['id' => 'specialization_id']);
    }

    public function getSpecialization_name()
    {
        return isset($this->specialization->name) ? $this->specialization->name : NULL;
    }

    /**
     * Gets query for [[Counterparty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounterparty()
    {
        return $this->hasOne(Counterparty::className(), ['id' => 'counterparty_id']);
    }

    public function getCounterparty_name()
    {
        return isset($this->counterparty->name) ? $this->counterparty->name : NULL;
    }

    /**
     * Gets query for [[Worker]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Worker::className(), ['id' => 'worker_id']);
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
        $this->start_date = !empty($this->start_date) ? date('Y-m-d', strtotime($this->start_date)) : NULL;
        $this->end_date = !empty($this->end_date) ? date('Y-m-d', strtotime($this->end_date)) : NULL;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->start_date = !empty($this->start_date) ? Yii::$app->formatter->asDate($this->start_date): NULL;
        $this->end_date = !empty($this->end_date) ? Yii::$app->formatter->asDate($this->end_date): NULL;
    }
}
