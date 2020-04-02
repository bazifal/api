<?php
namespace api\modules\v2\schema\mutation;

use common\models\Profile;
use common\models\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class MutationType
 * @package api\modules\v2\schema\mutation
 */
class MutationType extends ObjectType
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'user' => [
                        'type' => new UserMutationType(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function($root, $args) {
                            return User::findOne($args['id']);
                        },
                    ],
                    'profile' => [
                        'type' => new ProfileMutationType(),
                        'args' => [
                            'id' => Type::nonNull(Type::int()),
                        ],
                        'resolve' => function($root, $args) {
                            return Profile::findOne($args['id']);
                        },
                    ],
                ];
            }
        ];

        parent::__construct($config);
    }
}