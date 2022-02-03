<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%division}}`.
 */
class m220130_021752_create_division_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%division}}', [
            'id' => $this->primaryKey(),
            'department' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-department-id0',
            'division',
            'department'
        );

        $this->addForeignKey(
            'fk-department-id0',
            'division',
            'department',
            'department',
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
            'fk-department-id0',
            'division'
        );

        $this->dropIndex(
            'idx-department-id0',
            'division'
        );

        $this->dropTable('{{%division}}');
    }
}
