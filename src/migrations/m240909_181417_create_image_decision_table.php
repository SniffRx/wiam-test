<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_decision}}`.
 */
class m240909_181417_create_image_decision_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_decision}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
            'decision' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image_decision}}');
    }
}
