<?php

namespace app\models;

use Yii;
use yii\base\BaseObject;

/**
 * This is the model class for table "action_history".
 *
 * @property int $id
 * @property int $user
 * @property string $icon
 * @property string $category
 * @property int $current_record
 * @property string $action
 * @property int $created_at
 *
 * @property User $user0
 */
class ActionHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'icon', 'category', 'current_record', 'action', 'created_at'], 'required'],
            [['user', 'current_record', 'created_at'], 'integer'],
            [['icon', 'category', 'action'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'icon' => 'Icon',
            'category' => 'Category',
            'current_record' => 'Current Record',
            'action' => 'Action',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    public function ActionHistory($action, $category, $current_record, $icon) {
        $this->user = Yii::$app->user->identity->id;
        $this->action = $action;
        $this->category = $category;
        $this->current_record = $current_record;
        $this->icon = $icon;
        $this->created_at = time();
        if($this->validate()){
            $this->save();
            return true;
        }
        return false;
    }
}
