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
            'division' => $this->integer(),
            'last_name' => $this->string()->notNull(),
            'firs_name' => $this->string()->notNull(),
            'middle_name' => $this->string(),
            'birthdate' => $this->date()->notNull(),
            'gender' => $this->integer()->notNull(),
            'snils' => $this->string()->unique()->notNull(),
            'inn' => $this->string(),
            'phone' => $this->string(),
            'phone_work' => $this->string(),
            'phone_work_extension' => $this->string(),
            'email' => $this->string(),

            'passport_serial' => $this->string(),
            'passport_number' => $this->string(),
            'passport_date' => $this->date(),
            'passport_issued' => $this->string(),
            'passport_department_code' => $this->string(),
            'passport_birthplace' => $this->string(),

            'address_index' => $this->string(),
            'address_country' => $this->string(),
            'address_region' => $this->string(),
            'address_district' => $this->string(),
            'address_city' => $this->string(),
            'address_locality' => $this->string(),
            'address_street' => $this->string(),
            'address_house' => $this->string(),
            'address_body' => $this->string(),
            'address_building' => $this->string(),
            'address_apartment' => $this->string(),

            'work_position' => $this->integer(),
            'work_document' => $this->string(),
            'work_document_number' => $this->string(),
            'work_document_date' => $this->date(),
            'work_start' => $this->date(),
            'work_end' => $this->date(),

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

        $this->createIndex(
            'idx-work-position-id',
            'worker',
            'work_position'
        );

        $this->addForeignKey(
            'fk-work-position-id',
            'worker',
            'work_position',
            'position',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-division-id',
            'worker',
            'division'
        );

        $this->addForeignKey(
            'fk-division-id',
            'worker',
            'division',
            'division',
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

        $this->dropForeignKey(
            'fk-work-position-id',
            'worker'
        );

        $this->dropIndex(
            'idx-work-position-id',
            'worker'
        );

        $this->dropForeignKey(
            'fk-division-id',
            'worker'
        );

        $this->dropIndex(
            'idx-division-id',
            'worker'
        );

        $this->dropTable('{{%worker}}');
    }
}
