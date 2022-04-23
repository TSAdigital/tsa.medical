<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reference".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $reference_type_id
 * @property int $counterparty_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Counterparty $counterparty
 * @property ReferenceType $referenceType
 * @property Worker $worker
 */
class Reference extends ActiveRecord
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
        return 'reference';
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
            [['worker_id', 'reference_type_id', 'counterparty_id'], 'required'],
            [['worker_id', 'reference_type_id', 'counterparty_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['counterparty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Counterparty::className(), 'targetAttribute' => ['counterparty_id' => 'id']],
            [['reference_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReferenceType::className(), 'targetAttribute' => ['reference_type_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Worker::className(), 'targetAttribute' => ['worker_id' => 'id']],
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
            'reference_type_id' => 'Наименование',
            'counterparty_id' => 'Кем выдана',
            'start_date' => 'Дата выдачи',
            'end_date' => 'Срок действия',
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
        return $this->counterparty->name;
    }

    /**
     * Gets query for [[ReferenceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceType()
    {
        return $this->hasOne(ReferenceType::className(), ['id' => 'reference_type_id']);
    }

    public function getReference_type_name()
    {
        return $this->referenceType->name;
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
