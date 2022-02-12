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
            'counterparty' => $this->integer(),
            'passport_serial' => $this->string(),
            'passport_number' => $this->string(),
            'passport_date' => $this->date(),
            'passport_issued' => $this->string(),
            'passport_department_code' => $this->string(),
            'passport_birthplace' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%passport}}');
    }
}
