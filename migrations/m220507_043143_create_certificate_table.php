<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%certificate}}`.
 */
class m220507_043143_create_certificate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%certificate}}', [
            'id' => $this->primaryKey(),
            'worker_id' => $this->integer()->notNull(),
            'counterparty_id' => $this->integer()->notNull(),
            'specialization_id' => $this->integer()->notNull(),
            'serial' => $this->string(),
            'number' => $this->string(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-worker-certificate-id',
            'certificate',
            'worker_id'
        );

        $this->addForeignKey(
            'fk-worker-certificate-id',
            'certificate',
            'worker_id',
            'worker',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-worker-specialization-id',
            'certificate',
            'specialization_id'
        );

        $this->addForeignKey(
            'fk-worker-specialization-id',
            'certificate',
            'specialization_id',
            'specialization',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-worker-certificate-counterparty-id',
            'certificate',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-worker-certificate-counterparty-id',
            'certificate',
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
            'fk-worker-certificate-id',
            'certificate'
        );

        $this->dropIndex(
            'idx-worker-certificate-id',
            'certificate'
        );
        $this->dropForeignKey(
            'fk-worker-specialization-id',
            'certificate'
        );

        $this->dropIndex(
            'idx-worker-specialization-id',
            'certificate'
        );
        $this->dropForeignKey(
            'fk-worker-certificate-counterparty-id',
            'certificate'
        );

        $this->dropIndex(
            'idx-worker-certificate-counterparty-id',
            'certificate'
        );

        $this->dropTable('{{%certificate}}');
    }
}
