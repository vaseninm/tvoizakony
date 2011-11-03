<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'banned' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Banned',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'writer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Writer',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'politician' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Politician',
        'children' => array(
            'writer',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
        'children' => array(
            'politician',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
);