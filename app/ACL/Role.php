<?php

namespace Reactor\ACL;

use Illuminate\Database\Eloquent\Model;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Reactor\User;

class Role extends Model
{

    use Sortable, SearchableTrait, HasPermissions, RecordsActivity;

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
     * Users relation
     *
     * @return Relation
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Link a user to role
     *
     * @param int $id
     * @return User
     */
    public function associateUser($id)
    {
        return $this->users()->attach(
            User::findOrFail($id)
        );
    }

    /**
     * Unlink a user from role
     *
     * @param int $id
     * @return User
     */
    public function dissociateUser($id)
    {
        return $this->users()->detach(
            User::findOrFail($id)
        );
    }

}
