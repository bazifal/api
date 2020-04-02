<?php
namespace api\modules\v2\schema\mutation;

use api\modules\v2\schema\mutation\ProfileMutationType;
use common\models\Profile;
use common\models\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class UserMutationType
 * @package api\modules\v2\schema\mutation
 */
class UserMutationType extends ObjectType
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct([
            'fields' => function() {
                return [
                    'update' => [
                        'type' => Type::boolean(),
                        'description' => 'Update user data.',
                        'args' => [
                            'email' => Type::string(),
                            'username' => Type::string(),
                        ],
                        'resolve' => function(User $user, $args) {
                            $user->setAttributes($args);
                            return $user->save();
                        }
                    ],
                    'profile' => [
                        'type' => new ProfileMutationType(),
                        'description' => 'Edit profile directly from his address',
                        'resolve' => function(User $user) {
                            return $user->profile;
                        }
                    ]

                ];
            }
        ]);
    }
}