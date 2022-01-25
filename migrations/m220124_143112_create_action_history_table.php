<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%action_history}}`.
 */
class m220124_143112_create_action_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%action_history}}', [
            'id' => $this->primaryKey(),
            'icon' => $this->string()->notNull(),
            'user' => $this->integer()->notNull(),
            'action' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'current_record' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-user',
            'action_history',
            'user'
        );

        $this->addForeignKey(
            'fk-user',
            'action_history',
            'user',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%action_history}}');
    }
}
