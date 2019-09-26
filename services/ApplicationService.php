<?php

namespace app\services;

use app\models\Application;
use yii\db\Exception;

class ApplicationService
{
    protected $application;

    /**
     * ApplicationService constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param int $userId
     * @return Application
     * @throws Exception
     */
    public function create(int $userId)
    {
        $this->application->setAttributes([
            'user_id' => $userId,
            'money' => 200000,
            'percent' => \Yii::$app->params['percent'],
            'user_agent' => \Yii::$app->request->userAgent,
            'ip' => \Yii::$app->request->userIP
        ]);

        if ($this->application->validate() && $this->application->save()) {
            return $this->application;
        } else {
            throw new Exception('Ошибка при сохранении заявки', $this->application->errors);
        }
    }
}
