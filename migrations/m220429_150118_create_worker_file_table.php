<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%worker_file}}`.
 */
class m220429_150118_create_worker_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%worker_file}}', [
            'id' => $this->primaryKey(),
            'worker_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'url' => $this->string(),
            'date' => $this->date(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-worker-file-id',
            'worker_file',
            'worker_id'
        );

        $this->addForeignKey(
            'fk-worker-file-id',
            'worker_file',
            'worker_id',
            'worker',
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
            'fk-worker-file-id',
            'worker_file'
        );

        $this->dropIndex(
            'idx-worker-file-id',
            'worker_file'
        );

        $this->dropTable('{{%worker_file}}');
    }
}
