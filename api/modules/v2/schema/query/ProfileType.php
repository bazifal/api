<?php
namespace api\modules\v2\schema\query;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class ProfileType
 * @package api\modules\v2\schema
 */
class ProfileType extends ObjectType
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct([
            'fields' => function() {
                return [
                    'user_id' => [
                        'type' => Type::int(),
                    ],
                    'full_name' => [
                        'type' => Type::string(),
                    ],
                ];
            }
        ]);
    }

}