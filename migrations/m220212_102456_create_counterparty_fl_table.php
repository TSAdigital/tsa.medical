<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counterparty_fl}}`.
 */
class m220212_102456_create_counterparty_fl_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counterparty_fl}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string()->notNull(),
            'firs_name' => $this->string()->notNull(),
            'middle_name' => $this->string(),
            'birthdate' => $this->date()->notNull(),
            'gender' => $this->integer()->notNull(),
            'snils' => $this->string()->unique()->notNull(),
            'inn' => $this->string(),
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
        $this->dropTable('{{%counterparty_fl}}');
    }
}
