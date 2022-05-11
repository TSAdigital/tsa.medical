<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "action_history".
 *
 * @property int $id
 * @property string $icon
 * @property int $user
 * @property string $action
 * @property string $url
 * @property int $current_record
 * @property string $text
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
            ['icon', 'string', 'max' => 255],
            ['icon', 'required'],

            ['user', 'integer'],
            ['user', 'required'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],

            ['action', 'string', 'max' => 255],
            ['action', 'required'],

            ['url', 'string', 'max' => 255],
            ['url', 'required'],

            ['current_record', 'integer'],
            ['current_record', 'required'],

            ['text', 'string', 'max' => 255],
            ['text', 'required'],

            ['created_at', 'integer'],
            ['created_at', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icon' => 'Icon',
            'user' => 'User',
            'action' => 'Action',
            'url' => 'Url',
            'current_record' => 'Current Record',
            'text' => 'Text',
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

    public function ActionHistory($icon, $action, $url, $current_record, $text) {
        $this->user = Yii::$app->user->identity->id;
        $this->icon = $icon;
        $this->action = $action;
        $this->url = $url;
        $this->current_record = $current_record;
        $this->text = $text;
        $this->created_at = time();
        if($this->validate()){
            $this->save();
            return true;
        }
        return false;
    }
}
