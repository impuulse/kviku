<?php

namespace app\controllers\api;

use app\services\ApplicationService;
use app\services\UserService;
use yii\base\Module;
use Yii;
use yii\helpers\Json;

class UserController extends ApiController
{
    protected $userService;
    protected $applicationService;

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['sign-up'];
        return $behaviors;
    }

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param ApplicationService $applicationService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        ApplicationService $applicationService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->userService = $userService;
        $this->applicationService = $applicationService;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionSignUp()
    {
        $credentials = Json::decode(Yii::$app->request->rawBody);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = $this->userService->signUp($credentials);
            $this->applicationService->create($user->id);
            $transaction->commit();

            return $this->setResponse(true);

        } catch(\Exception $e) {
            $transaction->rollBack();

            return $this->setResponse(false, $e);
        }
    }
}
