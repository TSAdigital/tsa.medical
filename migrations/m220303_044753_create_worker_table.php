<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%worker}}`.
 */
class m220303_044753_create_worker_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%worker}}', [
            'id' => $this->primaryKey(),
            'counterparty_id' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'date_of_employment' => $this->date(),

            'phone' => $this->string(),
            'extension_phone' => $this->integer(),
            'email' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-counterparty-id',
            'worker',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-counterparty-id',
            'worker',
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
            'fk-counterparty-id',
            'worker'
        );

        $this->dropIndex(
            'idx-counterparty-id',
            'worker'
        );

        $this->dropTable('{{%worker}}');
    }
}
