<?php
/**
 * Metadata file for Gutschify module (OXID 6.x)
 *
 * @package Gutschify
 * @author Gutschify Team
 * @version 1.0.0
 */

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id' => 'gutschify',
    'title' => [
        'de' => 'Gutschify Embedded Home Widget',
        'en' => 'Gutschify Embedded Home Widget',
    ],
    'description' => [
        'de' => 'Zeigt die Gutschify eingebettete Startseite als konfigurierbares Widget an. Unterstützt das Laden verschiedener Sammlungen basierend auf der Konfiguration.',
        'en' => 'Displays Gutschify embedded home page as a configurable widget. Supports loading different collections based on configuration.',
    ],
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '1.0.0',
    'author' => 'Gutschify Team',
    'url' => 'https://gutschify.xxiii.tools',
    'email' => 'support@gutschify.xxiii.tools',
    'extend' => [],
    'blocks' => [],
    'settings' => [
        [
            'group' => 'main',
            'name' => 'gutschify_base_url',
            'type' => 'str',
            'value' => 'https://gutschify.xxiii.tools',
        ],
        [
            'group' => 'main',
            'name' => 'organization_id',
            'type' => 'str',
            'value' => '',
        ],
        [
            'group' => 'main',
            'name' => 'collection_slug',
            'type' => 'str',
            'value' => 'default',
        ],
        [
            'group' => 'main',
            'name' => 'widget_title',
            'type' => 'str',
            'value' => '',
        ],
        [
            'group' => 'main',
            'name' => 'cache_enabled',
            'type' => 'bool',
            'value' => '1',
        ],
        [
            'group' => 'main',
            'name' => 'cache_ttl',
            'type' => 'str',
            'value' => '3600',
        ],
    ],
    'templates' => [
        'gutschify_widget.tpl' => 'gutschify/views/widget/gutschify_widget.tpl',
    ],
    'events' => [],
];
