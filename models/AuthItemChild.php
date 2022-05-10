<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 * @property string $positionMenu
 * @property string $positionIndex
 * @property string $positionCreate
 * @property string $positionView
 * @property string $positionUpdate
 * @property string $positionActive
 * @property string $positionBlocked
 * @property string $positionHistory
 *
 * @property string $workerMenu
 * @property string $workerIndex
 * @property string $workerCreate
 * @property string $workerView
 * @property string $workerUpdate
 * @property string $workerActive
 * @property string $workerBlocked
 * @property string $workerHistory
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
            [['workerIndex', 'workerMenu', 'workerCreate', 'workerView', 'workerUpdate', 'workerActive', 'workerBlocked', 'workerHistory'], 'integer']
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
