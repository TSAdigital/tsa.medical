<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reference}}`.
 */
class m220423_130048_create_reference_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reference}}', [
            'id' => $this->primaryKey(),
            'worker_id' => $this->integer()->notNull(),
            'reference_type_id' => $this->integer()->notNull(),
            'counterparty_id' => $this->integer()->notNull(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-worker-reference-id',
            'reference',
            'worker_id'
        );

        $this->addForeignKey(
            'fk-worker-reference-id',
            'reference',
            'worker_id',
            'worker',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-reference-type-id',
            'reference',
            'reference_type_id'
        );

        $this->addForeignKey(
            'fk-reference-type-id',
            'reference',
            'reference_type_id',
            'reference_type',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-counterparty-reference-id',
            'reference',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-counterparty-reference-id',
            'reference',
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
            'fk-worker-reference-id',
            'reference'
        );

        $this->dropIndex(
            'idx-worker-reference-id',
            'reference'
        );

        $this->dropForeignKey(
            'fk-reference-type-id',
            'reference'
        );

        $this->dropIndex(
            'idx-reference-type-id',
            'reference'
        );

        $this->dropForeignKey(
            'fk-counterparty-reference-id',
            'reference'
        );

        $this->dropIndex(
            'idx-counterparty-reference-id',
            'reference'
        );

        $this->dropTable('{{%reference}}');
    }
}
