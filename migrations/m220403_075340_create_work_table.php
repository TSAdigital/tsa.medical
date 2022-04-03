<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%work}}`.
 */
class m220403_075340_create_work_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work}}', [
            'id' => $this->primaryKey(),
            'worker_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),
            'division_id' => $this->integer(),
            'work_start_date' => $this->date(),
            'position_id' => $this->integer()->notNull(),
            'busyness' => $this->integer(),
            'bet' => $this->decimal(3,2)->null(),
            'document' => $this->string(),
            'document_number' => $this->string(),
            'document_date' => $this->date(),
            'work_end_date' => $this->date(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-worker-id',
            'work',
            'worker_id'
        );

        $this->addForeignKey(
            'fk-worker-id',
            'work',
            'worker_id',
            'worker',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-position-id',
            'work',
            'position_id'
        );

        $this->addForeignKey(
            'fk-position-id',
            'work',
            'position_id',
            'position',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-department-id',
            'work',
            'department_id'
        );

        $this->addForeignKey(
            'fk-department-id',
            'work',
            'department_id',
            'department',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-division-id',
            'work',
            'division_id'
        );

        $this->addForeignKey(
            'fk-division-id',
            'work',
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
            'fk-worker-id',
            'work'
        );

        $this->dropIndex(
            'idx-worker-id',
            'work'
        );

        $this->dropForeignKey(
            'fk-position-id',
            'work'
        );

        $this->dropIndex(
            'idx-position-id',
            'work'
        );

        $this->dropForeignKey(
            'fk-department-id',
            'work'
        );

        $this->dropIndex(
            'idx-department-id',
            'work'
        );

        $this->dropForeignKey(
            'fk-division-id',
            'work'
        );

        $this->dropIndex(
            'idx-division-id',
            'work'
        );

        $this->dropTable('{{%work}}');
    }
}
