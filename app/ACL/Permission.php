<?php

namespace Reactor\ACL;

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Permission extends Model
{

    use Sortable, SearchableTrait, RecordsActivity;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'name';

    /**
     * Default sortable direction
     *
     * @var string
     */
    protected $sortableDirection = 'asc';

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

    /**
     * Roles relation
     *
     * @return Relation
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
