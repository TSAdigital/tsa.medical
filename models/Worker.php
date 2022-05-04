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
 * @property int $category
 * @property string|null date_of_employment
 * @property string|null date_of_dismissal
 * @property string|null $phone
 * @property string|null $extension_phone
 * @property string|null $email
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
    public $message;

    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const CATEGORY_SENIOR = 6;
    const CATEGORY_MIDDLE = 7;
    const CATEGORY_JUNIOR = 8;
    const CATEGORY_ADMIN = 9;
    const CATEGORY_OTHER = 10;

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

            ['category', 'required'],
            ['category', 'in', 'range' => [self::CATEGORY_SENIOR, self::CATEGORY_MIDDLE, self::CATEGORY_JUNIOR, self::CATEGORY_ADMIN, self::CATEGORY_OTHER]],
            ['category', 'validateDates'],

            ['counterparty_id', 'required'],
            ['counterparty_id', 'unique', 'message' => 'Сотрудник с таким "идентификатором" уже существует.'],
            ['counterparty_id', 'integer'],
            ['counterparty_id', 'exist', 'skipOnError' => true, 'targetClass' => CounterpartyFl::className(), 'targetAttribute' => ['counterparty_id' => 'id']],

            ['date_of_employment', 'date'],

            ['date_of_dismissal', 'date'],

            ['date_of_dismissal', 'validateDates'],

            ['phone', 'match', 'pattern' => '#^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})|(\d{1})(\(\d{3}\))(\d{3})\s+(\d{2})\s+(\d{2})$#', 'message' => 'Значение «Номер телефона» должно содержать 11 символов.'],
            ['phone', 'trim'],
            ['phone', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['extension_phone', 'integer'],
            ['extension_phone', 'string', 'max' => 6, 'tooLong' => 'Значение «Внутренний номер» должно содержать максимум 6 символов.'],
            ['extension_phone', 'trim'],
            ['extension_phone', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],

            ['email', 'email'],
            ['email', 'trim'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
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
            'category' => 'Категория',
            'counterparty_name' => 'Контрагент',
            'snils' => 'Снилс',
            'date_of_employment' => 'Дата принятия на работу',
            'date_of_dismissal' => 'Дата увольнения',
            'age' => 'Возраст',
            'work_time' => 'Время работы',
            'phone' => 'Номер телефона',
            'extension_phone' => 'Внутренний номер телефона',
            'email' => 'Адрес электронной почты',

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

    public function getSnils()
    {
        return $this->counterparty->snils;
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_INACTIVE => 'Аннулирована',
        ];
    }

    public static function getCategoriesArray()
    {
        return [
            self::CATEGORY_SENIOR => 'Высший медицинский персонал',
            self::CATEGORY_MIDDLE => 'Средний медицинский персонал',
            self::CATEGORY_JUNIOR => 'Младший медицинский персонал',
            self::CATEGORY_ADMIN => 'Административно-управленческий персонал',
            self::CATEGORY_OTHER => 'Прочий персонал',
        ];
    }

    public function getCategoryName()
    {
        return ArrayHelper::getValue(self::getCategoriesArray(), $this->category);
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
        $this->date_of_employment = !empty($this->date_of_employment) ? date('Y-m-d', strtotime($this->date_of_employment)) : NULL;
        $this->date_of_dismissal = !empty($this->date_of_dismissal) ? date('Y-m-d', strtotime($this->date_of_dismissal)) : NULL;

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->date_of_employment = !empty($this->date_of_employment) ? Yii::$app->formatter->asDate($this->date_of_employment): NULL;
        $this->date_of_dismissal = !empty($this->date_of_dismissal) ? Yii::$app->formatter->asDate($this->date_of_dismissal): NULL;
    }

    public function validateDates()
    {
        if(!empty($this->date_of_dismissal) and date('Y-m-d', strtotime($this->date_of_employment)) > date('Y-m-d', strtotime($this->date_of_dismissal))){
            $this->addError('date_of_employment','Дата принятия на работу не может быть больше даты увольнения');
            $this->addError('date_of_dismissal','Дата увольнения не может быть меньше даты принятия на работу');
        }
    }
}
