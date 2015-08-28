<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 7/8/15
 * Time: 4:19 PM
 */

namespace auction\modules\api\components;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\validators\StringValidator;
use yii\web\UnauthorizedHttpException;


class RestAuth extends HttpBearerAuth {

    const AUTH_HEADER = "X-AUTHORIZATION";
    const ERROR_CODE = 403;
    const ERROR_MESSAGE = "Access Denied";

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get(self::AUTH_HEADER,false);
        $validator = new StringValidator();

        if ($authHeader !== null && $validator->validate($authHeader)) {
            $identity = $user->loginByAccessToken($authHeader, get_class($this));

            if ($identity === null) {
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }

    public function beforeAction($action)
    {
        $response = $this->response ? : Yii::$app->getResponse();

        $identity = $this->authenticate(
            $this->user ? : Yii::$app->getUser(),
            $this->request ? : Yii::$app->getRequest(),
            $response
        );

        if ($identity !== null) {
            return true;
        } else {
            $this->challenge($response);
            $this->handleFailure($response);
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException(self::ERROR_MESSAGE, self::ERROR_CODE);
    }

}