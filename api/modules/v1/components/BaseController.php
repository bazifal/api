<?php
namespace api\modules\v1\components;

/**
 * Class BaseController
 * @package api\modules\v1\components
 */
class BaseController extends \api\components\BaseController
{
    const STATUS_OK = 'success';
    const STATUS_FAIL = 'fail';

    /**
     * Возвращает форматированный ответ
     * @param $status
     * @param null $data
     * @return array
     */
    public function respond($status, $data = null)
    {
        $result = [
            'status' => $status,
        ];
        if ($data !== null && $data !== false) {
            if ($status == static::STATUS_FAIL) {
                $result['errors'] = $data;
                \Yii::$app->response->statusCode = 400;
            } else {
                $result['data'] = $data;
            }
        }
        return $result;
    }
}