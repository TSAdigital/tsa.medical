<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "work".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $department_id
 * @property int|null $division_id
 * @property string|null $work_start_date
 * @property int $position_id
 * @property int|null $busyness
 * @property int|null $bet
 * @property string|null $document
 * @property string|null $document_number
 * @property string|null $document_date
 * @property string|null $work_end_date
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Department $department
 * @property Division $division
 * @property Position $position
 * @property Worker $worker
 *
 */
class Work extends ActiveRecord
{
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const EMPLOYMENT_MAIN = 7;
    const EMPLOYMENT_COMBINE= 8;
    const EMPLOYMENT_COMBINATION = 9;
    const EMPLOYMENT_OTHER = 10;


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
        return 'work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],

            ['busyness', 'default', 'value' => NULL],
            ['busyness', 'in', 'range' => [self::EMPLOYMENT_MAIN, self::EMPLOYMENT_COMBINE, self::EMPLOYMENT_COMBINATION, self::EMPLOYMENT_OTHER]],

            [['department_id', 'position_id'], 'required'],
            [['worker_id', 'department_id', 'division_id', 'position_id'], 'integer'],
            ['bet', 'match', 'pattern' => '#^(\d{1}).(\d{2})$#', 'message' => 'Значение «Ставка» должно содержать 3 символова.'],
            [['work_start_date', 'document_date', 'work_end_date'], 'safe'],
            [['document', 'document_number'], 'string', 'max' => 255],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['division_id'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['division_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
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
            'department_id' => 'Подразделение',
            'department_name' => 'Подразделение',
            'division_id' => 'Отделение',
            'division_name' => 'Отделение',
            'position_id' => 'Должность',
            'position_name' => 'Должность',
            'work_start_date' => 'Дата вступления в должность',
            'busyness' => 'Занятость',
            'bet' => 'Ставка',
            'work_end_date' => 'Дата окончания работы',
            'document' => 'Документ о назначении',
            'document_number' => 'Номер документа о назначении',
            'document_date' => 'Дата документа о назначении',
            'status' => 'Статус',
            'created_at' => 'Запись создана',
            'updated_at' => 'Запись изменена',
        ];
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
        return $this->division->name;
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

    public static function getEmploymentArray()
    {
        return [
            self::EMPLOYMENT_MAIN => 'Основная',
            self::EMPLOYMENT_COMBINE => 'Совмещение',
            self::EMPLOYMENT_COMBINATION => 'Совместительство',
            self::EMPLOYMENT_OTHER => 'Другое',
        ];
    }

    public function getEmploymentName()
    {
        return ArrayHelper::getValue(self::getEmploymentArray(), $this->busyness);
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
        $this->work_start_date = !empty($this->work_start_date) ? date('Y-m-d', strtotime($this->work_start_date)) : NULL;
        $this->work_end_date = !empty($this->work_end_date) ? date('Y-m-d', strtotime($this->work_end_date)) : NULL;
        $this->document_date = !empty($this->document_date) ? date('Y-m-d', strtotime($this->document_date)) : NULL;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->work_start_date = !empty($this->work_start_date) ? Yii::$app->formatter->asDate($this->work_start_date): NULL;
        $this->work_end_date = !empty($this->work_end_date) ? Yii::$app->formatter->asDate($this->work_end_date): NULL;
        $this->document_date = !empty($this->document_date) ? Yii::$app->formatter->asDate($this->document_date): NULL;
    }
}
