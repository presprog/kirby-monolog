<?php return array(
    'root' => array(
        'name' => 'presprog/kirby-logger',
        'pretty_version' => 'dev-master',
        'version' => 'dev-master',
        'reference' => '7f1e09543f6603efeffda514cc86fd3a14bd5d4b',
        'type' => 'kirby-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'monolog/monolog' => array(
            'pretty_version' => '3.3.1',
            'version' => '3.3.1.0',
            'reference' => '9b5daeaffce5b926cac47923798bba91059e60e2',
            'type' => 'library',
            'install_path' => __DIR__ . '/../monolog/monolog',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'presprog/kirby-logger' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '7f1e09543f6603efeffda514cc86fd3a14bd5d4b',
            'type' => 'kirby-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'psr/log' => array(
            'pretty_version' => '3.0.0',
            'version' => '3.0.0.0',
            'reference' => 'fe5ea303b0887d5caefd3d431c3e61ad47037001',
            'type' => 'library',
            'install_path' => __DIR__ . '/../psr/log',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'psr/log-implementation' => array(
            'dev_requirement' => false,
            'provided' => array(
                0 => '3.0.0',
            ),
        ),
    ),
);