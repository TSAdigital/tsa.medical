<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 * @property bool $viewPositionMenu
 * @property bool $viewPositionIndex
 * @property bool $viewPositionView
 * @property bool $viewPositionUpdate
 * @property bool $viewPositionActive
 * @property bool $viewPositionBlocked
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends ActiveRecord
{
    public $viewPositionMenu;
    public $viewPositionIndex;
    public $viewPositionView;
    public $viewPositionUpdate;
    public $viewPositionActive;
    public $viewPositionBlocked;
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
            [['viewPositionIndex', 'viewPositionMenu', 'viewPositionView', 'viewPositionUpdate', 'viewPositionActive', 'viewPositionBlocked'], 'safe']
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
