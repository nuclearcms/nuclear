<?php

namespace Reactor\ACL;

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Role extends Model
{

    use Sortable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['label', 'name'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'label';

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
            'label' => 10,
            'name'  => 10
        ]
    ];

    /**
     * Permissions relation
     *
     * @return Relation
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Helper for adding a permission
     *
     * @param Permission $permission
     * @return $permission
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }

}
