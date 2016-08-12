<?php

return [

    // Templates
    'form'          => 'laravel-form-builder::form',
    'text'          => 'fields.text',
    'textarea'      => 'fields.textarea',
    'checkbox'      => 'fields.checkbox',
    'select'        => 'fields.select',

    'custom_fields' => [
        'password' => 'Reactor\Http\Fields\PasswordField',
        'color' => 'Reactor\Http\Fields\ColorField',
        'slug' => 'Reactor\Http\Fields\SlugField',
        'markdown' => 'Reactor\Http\Fields\MarkdownField',
        'gallery' => 'Reactor\Http\Fields\GalleryField',
        'document' => 'Reactor\Http\Fields\DocumentField',
        'node_collection' => 'Reactor\Http\Fields\NodeCollectionField',
        'date' => 'Reactor\Http\Fields\DateField',
        'hidden' => 'Reactor\Http\Fields\HiddenField',
        'node' => 'Reactor\Http\Fields\NodeField',
    ]
];
