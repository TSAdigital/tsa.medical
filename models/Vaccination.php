<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vaccination".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $vaccine_id
 * @property int|null $counterparty_id
 * @property string $start_date
 * @property string $end_date
 * @property int $revaccination
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Counterparty $counterparty
 * @property Vaccine $vaccine
 * @property Worker $worker
 */
class Vaccination extends ActiveRecord
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
        return 'vaccination';
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
    public function rules()
    {
        return [
            [['worker_id', 'vaccine_id', 'start_date', 'end_date'], 'required'],
            [['worker_id', 'vaccine_id', 'counterparty_id', 'revaccination', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'end_date'], 'date'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::className(), 'targetAttribute' => ['worker_id' => 'id']],
            [['vaccine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vaccine::className(), 'targetAttribute' => ['vaccine_id' => 'id']],
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
            'vaccine_id' => 'Вид вакцины',
            'counterparty_id' => 'Вакцинация проходила в',
            'start_date' => 'Дата вакцинации',
            'end_date' => 'Скро действия',
            'revaccination' => 'Ревакцинация',

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
        return $this->hasOne(Counterparty::className(), ['id' => 'counterparty_id']);
    }

    public function getCounterparty_name()
    {
        return isset($this->counterparty->name) ? $this->counterparty->name : NULL;
    }

    /**
     * Gets query for [[Vaccine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVaccine()
    {
        return $this->hasOne(Vaccine::className(), ['id' => 'vaccine_id']);
    }

    public function getVaccine_name()
    {
        return isset($this->vaccine->name ) ? $this->vaccine->name : NULL;
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
