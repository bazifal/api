<?php
namespace api\modules\v2\controllers;

use api\components\BaseController;
use api\modules\v2\schema\mutation\MutationType;
use api\modules\v2\schema\query\QueryType;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;

/**
 * Class GraphqlController
 * @package api\modules\v2\controllers
 */
class GraphqlController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'POST'],
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionIndex(): array
    {
        list($query, $variables, $operation) = $this->getRequestData();

        if (empty($query)) {
            throw new BadRequestHttpException();
        }

        return GraphQL::executeQuery(
            new Schema([
                'query' => new QueryType(),
                'mutation' => new MutationType()
            ]),
            $query,
            null,
            null,
            $variables ?? null,
            $operation ?? null
        )->toArray();
    }

    /**
     * @return array
     */
    private function getRequestData(): array
    {
        $request = Yii::$app->request;
        $query = $request->get('query', $request->post('query', null));
        $variables = $request->get('variables', $request->post('variables'), null);
        $operation = $request->get('operation', $request->post('operation', null));

        //попробуем из потока вытащить
        if (empty($query)) {
            $input = Json::decode(file_get_contents('php://input'), true);
            $query = ArrayHelper::getValue($input, 'query');
            $variables = ArrayHelper::getValue($input, 'variables');
            $operation = ArrayHelper::getValue($input, 'operation');
        }
        return [$query, $variables, $operation];
    }
}