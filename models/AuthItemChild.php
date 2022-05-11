<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property int $positionMenu
 * @property int $positionIndex
 * @property int $positionCreate
 * @property int $positionView
 * @property int $positionUpdate
 * @property int $positionActive
 * @property int $positionBlocked
 * @property int $positionHistory
 *
 * @property int $workerMenu
 * @property int $workerIndex
 * @property int $workerCreate
 * @property int $workerView
 * @property int $workerUpdate
 * @property int $workerActive
 * @property int $workerBlocked
 * @property int $workerHistory
 *
 * @property int $workMenu
 * @property int $workIndex
 * @property int $workCreate
 * @property int $workView
 * @property int $workUpdate
 * @property int $workActive
 * @property int $workBlocked
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends ActiveRecord
{
    public $positionMenu;
    public $positionIndex;
    public $positionCreate;
    public $positionView;
    public $positionUpdate;
    public $positionActive;
    public $positionBlocked;
    public $positionHistory;

    public $workerMenu;
    public $workerIndex;
    public $workerCreate;
    public $workerView;
    public $workerUpdate;
    public $workerActive;
    public $workerBlocked;
    public $workerHistory;

    public $workMenu;
    public $workIndex;
    public $workCreate;
    public $workView;
    public $workUpdate;
    public $workActive;
    public $workBlocked;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
            [['positionIndex', 'positionMenu', 'positionCreate', 'positionView', 'positionUpdate', 'positionActive', 'positionBlocked', 'positionHistory'], 'integer'],
            [['workerIndex', 'workerMenu', 'workerCreate', 'workerView', 'workerUpdate', 'workerActive', 'workerBlocked', 'workerHistory'], 'integer'],
            [['workIndex', 'workMenu', 'workCreate', 'workView', 'workUpdate', 'workActive', 'workBlocked', 'workHistory'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * Gets query for [[Child0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }

    /**
     * Gets query for [[Parent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    public function checked($key, $roleName)
    {
        return !empty($this->find()->where(['child' => $key])->andWhere(['parent' => $roleName])->all());
    }
}
