<?php

$settings = array(
    'auto_escape' => false,
    'tag_systems' => array(
        'Echo' => array(
            'open' => '{',
            'close' => '}',
        ),
        'Common' => array(
            'open' => '{',
            'close' => '}',
        ),
        'Gettext' => array(
            'open' => '{{',
            'close' => '}}',
        ),
        'Comment' => array(
            'open' => '{#',
            'close' => '#}',
        ),
        'Static' => array(
            'open' => '{!',
            'close' => '}',
        ),
        'StaticGettext' => array(
            'open' => '{{!',
            'close' => '}}',
        ),
    ),
);