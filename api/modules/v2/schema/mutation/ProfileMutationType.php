<?php
namespace api\modules\v2\schema\mutation;

use api\modules\v2\schema\query\ProfileType;
use common\models\Profile;
use common\models\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class ProfileMutationType
 * @package api\modules\v2\schema\mutation
 */
class ProfileMutationType extends ObjectType
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
                        'description' => 'Update profile data.',
                        'args' => [
                            'user_id' => Type::int(),
                            'fullname' => Type::string(),
                        ],
                        'resolve' => function(Profile $profile, $args) {
                            $profile->setAttributes($args);
                            return $profile->save();
                        }
                    ],
                ];
            }
        ]);
    }
}