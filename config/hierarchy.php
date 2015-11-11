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
		'checkbox' => 'boolean',
		'select'   => 'string',
		'textarea' => 'text',
		'text'     => 'string',
		'number'   => 'double',
		'color'    => 'string',
		'markdown' => 'longtext',
		'file'     => 'unsignedInteger',
		'gallery'  => 'text',
		'slug'     => 'string',
		'tag'      => 'text',
		'password' => 'string'
    ],
    'default_type' => 'string',

    /*
	|--------------------------------------------------------------------------
	| Model Class Paths
	|--------------------------------------------------------------------------
	|
	| Used by type and field repositories.
	|
	*/
    'nodetype_model' => 'Reactor\Nodes\NodeType',
    'nodefield_model' => 'Reactor\Nodes\NodeField',

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