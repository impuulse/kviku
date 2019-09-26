<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $last_name Фамилия
 * @property string $first_name Имя
 * @property string $middle_name Отчество
 * @property string $birthday Дата рождения
 * @property int $passport Серия и номер паспорта
 * @property string $email Email
 * @property string $phone Номер телефона
 *
 * @property Application[] $applications
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'middle_name', 'birthday', 'email', 'phone'], 'required'],
            [['birthday'], 'date', 'format' => 'dd.mm.yyyy', 'message' => 'Неверный формат даты'],
            ['birthday', 'validateBirthday'],
            [['passport'], 'string', 'length' => 10],
            [['last_name', 'first_name', 'middle_name', 'email', 'phone'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
            ['email', 'filter', 'filter' => 'trim'],
            [['last_name', 'first_name', 'middle_name'], 'match', 'pattern' => '/^[аАбБвВгГдДеЕёЁжЖзЗиИйЙкКлЛмМнНоОпПрРсСтТуУфФхХцЦчЧшШщЩъЪыЫьЬэЭюЮяЯ]+$/', 'message' => '{attribute} должно состоять только из русских символов.'],
            [['phone'], 'match', 'pattern' => '/^((\+7)+([0-9]){10})$/', 'message' => '{attribute} должен быть в формате +7**********.']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @throws \Exception
     */
    public function validateBirthday($attribute, $params)
    {
        $birthday = new \DateTime($this->birthday);
        $now = new \DateTime();
        $diff = $now->diff($birthday)->y;
        if ($diff < 18 || $diff > 60) {
            $this->addError($attribute, 'Ваш возраст должен быть от 18 до 60 лет.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'birthday' => 'Дата рождения',
            'passport' => 'Серия и номер паспорта',
            'email' => 'Email',
            'phone' => 'Номер телефона',
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (!empty($this->passport)) {
            $this->passport = preg_replace('/\D/', '', $this->passport);
        }
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        if (!empty($this->passport)) {
            $this->birthday = date('Y-m-d', strtotime($this->birthday));
        }
        parent::afterValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['user_id' => 'id']);
    }
}
