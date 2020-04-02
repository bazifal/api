<?php
namespace api\modules\v2\schema\query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use common\models\User;

/**
 * Class UserType
 * @package api\modules\v2\schema
 */
class UserType extends ObjectType
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct([
            'fields' => function() {
                return [
                    'email' => [
                        'type' => Type::string(),
                    ],
                    'username' => [
                        'type' => Type::string(),
                    ],
                    'created_at' => [
                        'type' => Type::string(),
                        'description' => 'Date when user was created',
                        'args' => [
                            'format' => Type::string(),
                        ],
                        'resolve' => function(User $user, $args) {
                            if (isset($args['format'])) {
                                return date($args['format'], strtotime($user->created_at));
                            }
                            return $user->created_at;
                        },
                    ],
                    'profile' => [
                        'type' => new ProfileType(),
                        'resolve' => function(User $user) {
                            return $user->profile;
                        },
                    ],
                ];
            }
        ]);
    }
}