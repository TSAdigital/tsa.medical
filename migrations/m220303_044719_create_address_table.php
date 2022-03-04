<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m220303_044719_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'index' => $this->string(),
            'country' => $this->string(),
            'region' => $this->string(),
            'district' => $this->string(),
            'city' => $this->string(),
            'locality' => $this->string(),
            'street' => $this->string(),
            'house' => $this->string(),
            'body' => $this->string(),
            'building' => $this->string(),
            'office' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
