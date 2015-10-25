<?php

namespace Reactor\Nodes;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Chronicle\RecordsActivity;
use Kenarkose\Sortable\Sortable;
use Nicolaslopezj\Searchable\SearchableTrait;

class NodeField extends Eloquent
{
    use Sortable, SearchableTrait, RecordsActivity;

}
