<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%auth_item}}`.
 */
class m220123_134214_add_status_column_to_auth_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->addColumn('{{%auth_item}}', 'status', $this->smallInteger()->notNull()->defaultValue(10));
        //$this->addColumn('{{%auth_item}}', 'id', $this->integer()->first()->unique());
        //$this->alterColumn('{{%auth_item}}', 'id', $this->integer(11) . ' NOT NULL AUTO_INCREMENT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%auth_item}}', 'status');
    }
}
