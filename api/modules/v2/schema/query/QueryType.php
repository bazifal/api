<?php
namespace api\modules\v2\schema\query;

use common\models\User;
use common\models\Profile;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class QueryType
 * @package api\modules\v2\schema
 */
class QueryType extends ObjectType
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct([
            'fields' => function() {
                return [
                    'user' => [
                        'type' => new UserType(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function($root, $args) {
                            return User::findOne($args['id']);
                        }
                    ],
                    'profile' => [
                        'type' => new ProfileType(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function($root, $args) {
                            return Profile::findOne($args['id']);
                        }
                    ],
                ];
            }
        ]);
    }
}