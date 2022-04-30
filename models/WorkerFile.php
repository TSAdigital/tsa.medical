<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "worker_file".
 *
 * @property int $id
 * @property int $worker_id
 * @property string $name
 * @property string $url
 * @property string|null $date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Worker $worker
 */
class WorkerFile extends ActiveRecord
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
        return 'worker_file';
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
            [['worker_id', 'name'], 'required'],
            [['worker_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
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
            'name' => 'Наименование',
            'url' => 'url',
            'date' => 'Дата',
            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
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
        $this->date = !empty($this->date) ? date('Y-m-d', strtotime($this->date)) : NULL;
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->date = !empty($this->date) ? Yii::$app->formatter->asDate($this->date): NULL;
    }
}
