<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%passport}}`.
 */
class m220212_105730_create_passport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%passport}}', [
            'id' => $this->primaryKey(),
            'counterparty_id' => $this->integer()->notNull(),
            'passport_serial' => $this->string()->notNull(),
            'passport_number' => $this->string()->notNull(),
            'passport_date' => $this->date()->notNull(),
            'passport_issued' => $this->string()->notNull(),
            'passport_department_code' => $this->string()->notNull(),
            'passport_birthplace' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-passport-counterparty-id',
            'passport',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-passport-counterparty-id',
            'passport',
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
            'fk-passport-counterparty-id',
            'passport'
        );

        $this->dropIndex(
            'idx-passport-counterparty-id',
            'passport'
        );

        $this->dropTable('{{%passport}}');
    }
}
