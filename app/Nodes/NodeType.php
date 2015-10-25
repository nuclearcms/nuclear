<?php

namespace Reactor\Nodes;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;

class NodeType extends Eloquent
{
    use Sortable, SearchableTrait, RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'description', 'visible', 'hides_nodes', 'color'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'label'];

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
            'name'  => 10,
            'label' => 10
        ]
    ];

    /**
     * Fields relation
     *
     * @return HasMany
     */
    public function fields()
    {
        return $this->hasMany(NodeField::class);
    }

    /**
     * Add a field to the node type
     *
     * @param NodeField $field
     * @return NodeField
     */
    public function addField(NodeField $field)
    {
        return $this->fields()->attach($field);
    }

    /**
     * Remove a field from the node type
     *
     * @param NodeField $field
     * @return NodeField
     */
    public function removeField(NodeField $field)
    {
        return $this->fields()->detach($field);
    }

}
