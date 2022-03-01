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
            'counterparty_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
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

        $this->createIndex(
            'idx-address_fl-counterparty-id',
            'address_fl',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-address_fl-counterparty-id',
            'address_fl',
            'counterparty_id',
            'counterparty_fl',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-address_fl-counterparty-id',
            'address_fl'
        );

        $this->dropIndex(
            'idx-address_fl-counterparty-id',
            'address_fl'
        );

        $this->dropTable('{{%address_fl}}');
    }
}
