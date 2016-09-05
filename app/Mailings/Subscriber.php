<?php


namespace Reactor\Mailings;


use Illuminate\Database\Eloquent\Model;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Subscriber extends Model {

    use Sortable, SearchableTrait, RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'name',
        'address', 'city', 'country', 'postal_code', 'nationality', 'national_id',
        'tel', 'tel_mobile', 'fax', 'additional'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['email', 'name', 'created_at'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'email';

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
            'email'  => 10,
            'name' => 10
        ]
    ];

    /**
     * Lists relation
     *
     * @return Relation
     */
    public function lists()
    {
        return $this->belongsToMany(MailingList::class);
    }

    /**
     * Link a list to subscriber
     *
     * @param int $id
     * @return MailingList
     */
    public function associateList($id)
    {
        return $this->lists()->attach(
            MailingList::findOrFail($id)
        );
    }

    /**
     * Unlink a list from subscriber
     *
     * @param int $id
     * @return MailingList
     */
    public function dissociateList($id)
    {
        return $this->lists()->detach(
            MailingList::findOrFail($id)
        );
    }

}