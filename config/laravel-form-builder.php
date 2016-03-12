<?php

return [

    // Templates
    'form'          => 'laravel-form-builder::form',
    'text'          => 'fields.text',
    'textarea'      => 'fields.textarea',
    // 'button'        => 'laravel-form-builder::button',
    // 'radio'         => 'laravel-form-builder::radio',
    'checkbox'      => 'fields.checkbox',
    'select'        => 'fields.select',
    // 'choice'        => 'laravel-form-builder::choice',
    // 'collection'    => 'laravel-form-builder::collection',
    // 'static'        => 'laravel-form-builder::static',

    'custom_fields' => [
        'password' => 'Reactor\Http\Forms\Fields\PasswordField',
        'color' => 'Reactor\Http\Forms\Fields\ColorField',
        'slug' => 'Reactor\Http\Forms\Fields\SlugField',
        'markdown' => 'Reactor\Http\Forms\Fields\MarkdownField',
        'gallery' => 'Reactor\Http\Forms\Fields\GalleryField',
        'document' => 'Reactor\Http\Forms\Fields\DocumentField',
        'tag' => 'Reactor\Http\Forms\Fields\TagField',
        'node_collection' => 'Reactor\Http\Forms\Fields\NodeCollectionField',
        'date' => 'Reactor\Http\Forms\Fields\DateField',
        'hidden' => 'Reactor\Http\Forms\Fields\HiddenField'
    ]
];
