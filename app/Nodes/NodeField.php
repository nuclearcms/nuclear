<?php

namespace Reactor\Nodes;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;

class NodeField extends Eloquent
{
    use Sortable, RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'description', 'position', 'type', 'visible',
        'rules', 'default_value', 'value', 'options'];

    /**
     * Sortable columns
     *
     * @var array
     */
    protected $sortableColumns = ['name', 'label', 'position'];

    /**
     * Default sortable key
     *
     * @var string
     */
    protected $sortableKey = 'position';

    /**
     * Default sortable direction
     *
     * @var string
     */
    protected $sortableDirection = 'asc';

    /**
     * Parent node type relation
     *
     * @return BelongsTo
     */
    public function nodeType()
    {
        return $this->belongsTo(NodeType::class);
    }

}
