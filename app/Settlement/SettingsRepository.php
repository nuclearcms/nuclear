<?php

namespace Reactor\Settlement;


use Kenarkose\Settlement\Repository\LaravelJSONRepository;

class SettingsRepository extends LaravelJSONRepository {

    /**
     * Allowable setting types
     *
     * @var array
     */
    protected $types = [
        'text',
        'textarea',
        'boolean',
        'url',
        'email',
        'number',
        'document',
        'color',
        'datetime'
    ];

    /**
     * Default setting type
     *
     * @var string
     */
    protected $defaultType = 'text';

    /**
     * Returns the available types
     *
     * @return array
     */
    public function getAvailableTypes()
    {
        $types = [];

        foreach($this->types as $type)
        {
            $types[$type] = trans('settings.type_' . $type);
        }

        return $types;
    }

    /**
     * Getter for groups
     *
     * @return array
     */
    public function getGroups()
    {
        $groups = [];

        foreach($this->groups() as $key => $name)
        {
            $groups[$key] = (trans()->has('settings.group_' . $key)) ? trans('settings.group_' . $key) : $name;
        }

        return $groups;
    }

}