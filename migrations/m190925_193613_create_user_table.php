<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190925_193613_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'last_name' => $this->string()->notNull()->comment('Фамилия'),
            'first_name' => $this->string()->notNull()->comment('Имя'),
            'middle_name' => $this->string()->notNull()->comment('Отчество'),
            'birthday' => $this->date()->notNull()->comment('Дата рождения'),
            'passport' => $this->char(10)->comment('Серия и номер паспорта'),
            'email' => $this->string()->unique()->notNull()->comment('Email'),
            'phone' => $this->string()->notNull()->comment('Номер телефона')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
