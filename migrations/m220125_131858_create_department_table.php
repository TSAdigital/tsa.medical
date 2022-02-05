<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%department}}`.
 */
class m220125_131858_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'index' => $this->string(),
            'country' => $this->string(),
            'region' => $this->string(),
            'district' => $this->string(),
            'city' => $this->string(),
            'locality' => $this->string(),
            'street' => $this->string(),
            'house' => $this->string(),
            'body' => $this->string(),
            'building' => $this->string(),
            'office' => $this->string(),
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
        $this->dropTable('{{%department}}');
    }
}
