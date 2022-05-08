<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vaccine}}`.
 */
class m220508_133713_create_vaccine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vaccine}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),

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
        $this->dropTable('{{%vaccine}}');
    }
}
