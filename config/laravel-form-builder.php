<?php

return [

    // Templates
    'form'          => 'laravel-form-builder::form',
    'text'          => 'fields.text',
    'textarea'      => 'fields.textarea',
    'checkbox'      => 'fields.checkbox',
    'select'        => 'fields.select',

    'custom_fields' => [
        'password' => 'Reactor\Html\Fields\PasswordField',
        'color' => 'Reactor\Html\Fields\ColorField',
        'slug' => 'Reactor\Html\Fields\SlugField',
        'hidden' => 'Reactor\Html\Fields\HiddenField',
        'relation' => 'Reactor\Html\Fields\RelationField',
        'markdown' => 'Reactor\Html\Fields\MarkdownField',
        'gallery' => 'Reactor\Html\Fields\GalleryField',
        'document' => 'Reactor\Html\Fields\DocumentField',
        'node_collection' => 'Reactor\Html\Fields\NodeCollectionField',
        'node' => 'Reactor\Html\Fields\NodeField',
        'date' => 'Reactor\Html\Fields\DateField',
    ]
];
