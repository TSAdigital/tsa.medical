<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counterparty}}`.
 */
class m220209_033540_create_counterparty_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counterparty}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'full_name' => $this->string(),
            'inn' => $this->string()->notNull()->unique(),
            'kpp' => $this->string(),
            'ogrn' => $this->string(),
            'okpo' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'web_site' => $this->string(),

            'director_last_name' => $this->string(),
            'director_first_name' => $this->string(),
            'director_middle_name' => $this->string(),
            'director_position' => $this->integer(),
            'director_document' => $this->string(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-counterparty-director-position-id',
            'counterparty',
            'director_position'
        );

        $this->addForeignKey(
            'fk-counterparty-director-position-id',
            'counterparty',
            'director_position',
            'position',
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
            'fk-counterparty-director-position-id',
            'counterparty'
        );

        $this->dropIndex(
            'idx-counterparty-director-position-id',
            'counterparty'
        );
        $this->dropTable('{{%counterparty}}');
    }
}
