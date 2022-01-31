<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%worker}}`.
 */
class m220131_034931_create_worker_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%worker}}', [
            'id' => $this->primaryKey(),
            'department' => $this->integer()->notNull(),
            'last_name' => $this->string()->notNull(),
            'firs_name' => $this->string()->notNull(),
            'middle_name' => $this->string(),
            'birthdate' => $this->date()->notNull(),
            'gender' => $this->integer()->notNull(),
            'snils' => $this->bigInteger()->unique()->notNull(),
            'inn' => $this->bigInteger(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-department-id',
            'worker',
            'department'
        );

        $this->addForeignKey(
            'fk-department-id',
            'worker',
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
            'fk-department-id',
            'worker'
        );

        $this->dropIndex(
            'idx-department-id',
            'worker'
        );

        $this->dropTable('{{%worker}}');
    }
}
