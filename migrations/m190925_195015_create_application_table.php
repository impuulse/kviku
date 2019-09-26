<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m190925_195015_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'money' => $this->decimal(12, 3)->notNull()->comment('Сумма'),
            'percent' => $this->decimal(6, 3)->notNull()->comment('Процентная ставка'),
            'user_agent' => $this->string()->notNull()->comment('User agent'),
            'ip' => $this->binary(16)->notNull()->comment('IP')
        ]);

        $this->addForeignKey('application-user_id', '{{%application}}', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('application-user_id', '{{%application}}');
        $this->dropTable('{{%application}}');
    }
}
