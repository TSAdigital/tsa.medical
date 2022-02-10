<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counterpartie}}`.
 */
class m220209_033540_create_counterparty_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counterpartie}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'full_name' => $this->string(),
            'inn' => $this->string()->notNull()->unique(),
            'kpp' => $this->string(),
            'ogrn' => $this->string(),
            'okpo' => $this->string(),
            'director' => $this->string(),
            'director_document' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'web_site' => $this->string(),

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

            'contact_name' => $this->string(),
            'contact_position' => $this->string(),
            'contact_phone' => $this->string(),
            'contact_email' => $this->string(),

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
        $this->dropTable('{{%counterpartie}}');
    }
}
