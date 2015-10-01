<?php
return [
    'createResource' => [
        'type' => 2,
        'description' => 'Create a resource',
    ],
    'updateResource' => [
        'type' => 2,
        'description' => 'Update a resource',
    ],
    'viewResource' => [
        'type' => 2,
        'description' => 'View a resource',
    ],
    'workResource' => [
        'type' => 2,
        'description' => 'Work with a Resource',
        'children' => [
            'viewResource',
            'createResource',
            'updateResource',
        ],
    ],
    'createTopic' => [
        'type' => 2,
        'description' => 'Create a topic',
    ],
    'updateTopic' => [
        'type' => 2,
        'description' => 'Update topic',
    ],
    'hideTopic' => [
        'type' => 2,
        'description' => 'Hide topic',
    ],
    'workTopic' => [
        'type' => 2,
        'description' => 'Work with a Topic',
        'children' => [
            'createTopic',
            'updateTopic',
            'hideTopic',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'usergrouprule',
        'children' => [
            'createTopic',
            'updateTopic',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'usergrouprule',
        'children' => [
            'workResource',
            'workTopic',
        ],
    ],
];
