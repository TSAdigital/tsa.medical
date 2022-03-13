<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m220303_044752_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'counterparty_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'position' => $this->integer(),
            'phone' => $this->string(),
            'phone_extension' => $this->string(),
            'email' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-contact-counterparty-id',
            'contact',
            'counterparty_id'
        );

        $this->addForeignKey(
            'fk-contact-counterparty-id',
            'contact',
            'counterparty_id',
            'counterparty',
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
            'fk-contact-counterparty-id',
            'contact'
        );

        $this->dropIndex(
            'idx-contact-counterparty-id',
            'contact'
        );

        $this->dropTable('{{%contact}}');
    }
}
