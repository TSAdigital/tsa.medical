<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address_fl}}`.
 */
class m220225_040453_create_address_fl_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address_fl}}', [
            'id' => $this->primaryKey(),
            'counterparty' => $this->integer(),
            'type' => $this->integer(),
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
            'apartment' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address_fl}}');
    }
}
