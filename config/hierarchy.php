<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Generated Entities Path
	|--------------------------------------------------------------------------
	|
	| The directory which holds gen\ namespace and contains the
    | generated files that Hierarchy needs.
    | The path is defined relative to base directory.
	|
	*/
    'gen_path' => 'gen',

    /*
	|--------------------------------------------------------------------------
	| Type Map and Default Type
	|--------------------------------------------------------------------------
	|
	| Maps field types to schema builders column types, to be used
    | by MigrationBuilder. The default column type is a string.
    | Add or remove as many as you wish.
	|
	*/
    'type_map' => [
        'text'     => 'string',
        'textarea' => 'text',
        'markdown' => 'longtext',
        'document' => 'unsignedInteger',
        'gallery'  => 'text',
        'checkbox' => 'boolean',
        'select'   => 'string',
        'number'   => 'double',
        'color'    => 'string',
        'slug'     => 'string',
        'password' => 'string',
        'date'     => 'timestamp',
        'node_collection' => 'text',
        'node'     => 'integer',
        'relation' => 'text'
    ],
    'default_type' => 'string',

    /*
	|--------------------------------------------------------------------------
	| Model Class Paths
	|--------------------------------------------------------------------------
	|
	| Used by type and field repositories,
    | and the node_type model is used by the Node model.
	|
	*/
    'nodetype_model' => 'Nuclear\Hierarchy\NodeType',
    'nodefield_model' => 'Nuclear\Hierarchy\NodeField',

    /*
	|--------------------------------------------------------------------------
	| Node Sources Table
	|--------------------------------------------------------------------------
	|
	| Only necessary for the source table generation template as
    | a foreign key is needed for the node relations to work.
	|
	*/
    'nodesources_table' => 'node_sources'

];