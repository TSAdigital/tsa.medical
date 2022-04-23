<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reference_type}}`.
 */
class m220423_085100_create_reference_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reference_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),

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
        $this->dropTable('{{%reference_type}}');
    }
}
