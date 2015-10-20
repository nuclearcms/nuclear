<?php
namespace Reactor\Documents;


use Kenarkose\Files\Determine\AutoDeterminesType;
use Kenarkose\Ownable\AutoAssociatesOwner;
use Kenarkose\Ownable\Ownable;
use Kenarkose\Sortable\Sortable;
use Kenarkose\Transit\File\File as TransitFile;
use Nicolaslopezj\Searchable\SearchableTrait;

class Media extends TransitFile {

    use Ownable, AutoAssociatesOwner, AutoDeterminesType,
        Sortable, SearchableTrait;

    /**
     * @var string
     */
    protected $table = 'media';

    /**
     * The fillable fields for the model.
     *
     * @var  array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['created_at'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'created_at';

    /**
     * Default sortable direction
     *
     * @var string
     */
    protected $sortableDirection = 'desc';

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name'  => 10
        ]
    ];

}