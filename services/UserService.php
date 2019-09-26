<?php

namespace app\services;

use app\models\User;
use yii\db\Exception;

class UserService
{
    protected $user;

    /**
     * UserService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $credentials
     * @return User
     * @throws Exception
     */
    public function signUp(array $credentials)
    {
        $this->user->setAttributes($credentials);

        if ($this->user->validate() && $this->user->save()) {
            return $this->user;
        } else {
            throw new Exception('Ошибка при сохранении пользователя', $this->user->errors);
        }
    }
}
