<?php
namespace api\modules\v1\controllers;

use api\modules\v1\components\BaseController;
use common\models\User;
use yii\web\NotFoundHttpException;

/**
 * Class UserController
 * @package api\modules\v1\controllers
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'view' => ['GET'],
            'update' => ['PUT']
        ];
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): array
    {
        $model = $this->findModel($id);
        return $this->respond(self::STATUS_OK, [
            'username' => $model->username,
            'email' => $model->email
        ]);
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): array
    {
        $model = $this->findModel($id);
        $errors = null;
        //TODO: принебрег что на входе может быть поток, вместо поста
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->respond(self::STATUS_OK);
        }
        return $this->respond(self::STATUS_FAIL, $model->getErrors());
    }

    /**
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function findModel(int $id): User
    {
        /** @var User $model */
        $model = User::findOne($id);
        if (is_null($model)) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}