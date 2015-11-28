<?php
namespace Reactor\Documents;


use Kenarkose\Files\Determine\AutoDeterminesType;
use Kenarkose\Ownable\AutoAssociatesOwner;
use Kenarkose\Ownable\Ownable;
use Kenarkose\Sortable\Sortable;
use Kenarkose\Transit\File\File as TransitFile;
use Laracasts\Presenter\PresentableTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class Media extends TransitFile {

    use Ownable, AutoAssociatesOwner, AutoDeterminesType,
        Sortable, SearchableTrait, PresentableTrait;

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
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\MediaPresenter';

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
            'name'     => 10,
            'mimetype' => 5
        ]
    ];

    /**
     * Path accessor
     *
     * @param string $value
     * @return string
     */
    public function getPathAttribute($value)
    {
        return $value;
    }

    /**
     * Getter for file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return upload_path($this->getAttribute('path'));
    }

    /**
     * Public url accessor
     *
     * @return string
     */
    public function getPublicURL()
    {
        return uploaded_asset($this->path);
    }

    /**
     * Checks if the media is an image
     *
     * @return bool
     */
    public function isImage()
    {
        return ($this->type === 'image');
    }

    /**
     * Converts model attributes to array
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'thumbnail' => $this->present()->thumbnail
        ]);
    }

}