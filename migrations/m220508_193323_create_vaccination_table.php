<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vaccination}}`.
 */
class m220508_193323_create_vaccination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vaccination}}', [
            'id' => $this->primaryKey(),
            'worker_id' => $this->integer()->notNull(),
            'vaccine_id' => $this->integer()->notNull(),
            'counterparty_id' => $this->integer(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'revaccination' => $this->smallInteger()->notNull()->defaultValue(10),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-worker-vaccination-id',
            'vaccination',
            'worker_id'
        );
        $this->addForeignKey(
            'fk-worker-vaccination-id',
            'vaccination',
            'worker_id',
            'worker',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-worker-vaccination-counterparty-id',
            'vaccination',
            'counterparty_id'
        );
        $this->addForeignKey(
            'fk-worker-vaccination-counterparty-id',
            'vaccination',
            'counterparty_id',
            'counterparty',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-worker-vaccination-vaccine-id',
            'vaccination',
            'vaccine_id'
        );
        $this->addForeignKey(
            'fk-worker-vaccination-vaccine-id',
            'vaccination',
            'vaccine_id',
            'vaccine',
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
            'fk-worker-vaccination-id',
            'vaccination'
        );
        $this->dropIndex(
            'idx-worker-vaccination-id',
            'vaccination'
        );

        $this->dropForeignKey(
            'fk-worker-vaccination-counterparty-id',
            'vaccination'
        );
        $this->dropIndex(
            'idx-worker-vaccination-counterparty-id',
            'vaccination'
        );

        $this->dropForeignKey(
            'fk-worker-vaccination-vaccine-id',
            'vaccination'
        );
        $this->dropIndex(
            'idx-worker-vaccination-vaccine-id',
            'vaccination'
        );

        $this->dropTable('{{%vaccination}}');
    }
}
