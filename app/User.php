<?php

namespace Reactor;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Laracasts\Presenter\Contracts\PresentableInterface;
use Laracasts\Presenter\PresentableTrait;
use Nicolaslopezj\Searchable\SearchableTrait;
use Reactor\ACL\HasPermissions;
use Reactor\ACL\HasRoles;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    PresentableInterface {

    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes,
        PresentableTrait, Sortable, SearchableTrait,
        HasRoles, HasPermissions, RecordsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'first_name', 'last_name', 'avatar_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\UserPresenter';

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['first_name', 'email', 'created_at'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'first_name';

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
            'first_name' => 10,
            'last_name'  => 10,
            'email'      => 10
        ]
    ];

    /**
     * Events for recording
     *
     * @var array
     */
    protected static $recordEvents = ['created', 'deleted'];

    /**
     * Password setter
     *
     * @param string $password
     * @return $this for chaining
     */
    public function setPassword($password)
    {
        $this->attributes['password'] = bcrypt($password);

        return $this;
    }

    /**
     * Static constructor for User
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $user = new static($attributes);

        $user->setPassword($attributes['password']);

        $user->save();

        return $user;
    }

}