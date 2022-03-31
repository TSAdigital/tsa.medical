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
            'position_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
            'division_id' => $this->integer(),
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

        $this->createIndex(
            'idx-position-id',
            'worker',
            'position_id'
        );

        $this->addForeignKey(
            'fk-position-id',
            'worker',
            'position_id',
            'position',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-department-id',
            'worker',
            'department_id'
        );

        $this->addForeignKey(
            'fk-department-id',
            'worker',
            'department_id',
            'department',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-division-id',
            'worker',
            'division_id'
        );

        $this->addForeignKey(
            'fk-division-id',
            'worker',
            'division_id',
            'division',
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

        $this->dropForeignKey(
            'fk-position-id',
            'worker'
        );

        $this->dropIndex(
            'idx-position-id',
            'worker'
        );

        $this->dropForeignKey(
            'fk-department-id',
            'worker'
        );

        $this->dropIndex(
            'idx-department-id',
            'worker'
        );

        $this->dropForeignKey(
            'fk-division-id',
            'worker'
        );

        $this->dropIndex(
            'idx-division-id',
            'worker'
        );

        $this->dropTable('{{%worker}}');
    }
}