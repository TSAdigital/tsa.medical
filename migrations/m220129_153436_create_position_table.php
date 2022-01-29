<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%position}}`.
 */
class m220129_153436_create_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
            'name_i' => $this->string(),
            'name_r' => $this->string(),
            'name_d' => $this->string(),
            'name_v' => $this->string(),
            'name_t' => $this->string(),
            'name_p' => $this->string(),
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
        $this->dropTable('{{%position}}');
    }
}
