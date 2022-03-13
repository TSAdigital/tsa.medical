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
            'counterparty_id' => $this->integer()->notNull(),
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

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-address-counterparty-id',
            'address',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-address-counterparty-id',
            'address',
            'counterparty_id',
            'counterparty',
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
            'fk-address-counterparty-id',
            'address'
        );

        $this->dropIndex(
            'idx-address-counterparty-id',
            'address'
        );

        $this->dropTable('{{%address}}');
    }
}
