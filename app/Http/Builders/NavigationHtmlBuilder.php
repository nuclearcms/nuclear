<?php

namespace Reactor\Http\Builders;


use Illuminate\Contracts\Auth\Access\Gate;

class NavigationHtmlBuilder {

    /**
     * @var Gate
     */
    protected $gate;

    /**
     * @var array
     */
    protected $items = [
        'contents' => [
            'title' => 'nodes.title',
            'permission' => 'ACCESS_CONTENTS',
            'icon' => 'icon-flow-tree',
            'items' => [
                ['title' => 'nodes.not-published_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-cancel-circled', 'options' => ['not-published']],
                ['title' => 'nodes.locked_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-lock', 'options' => ['locked']],
                ['title' => 'nodes.invisible_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-eye-off', 'options' => ['invisible']],
                'splitter',
                ['title' => 'nodes.published_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-ok-circled', 'options' => ['published']],
                ['title' => 'nodes.draft_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-circle-empty', 'options' => ['draft']],
                ['title' => 'nodes.pending_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-clock', 'options' => ['pending']],
                ['title' => 'nodes.archived_nodes', 'route' => 'reactor.contents.index', 'icon' => 'icon-dot-circled', 'options' => ['archived']]
            ]
        ],
        'tags' => [
            'title' => 'tags.title',
            'permission' => 'ACCESS_TAGS',
            'icon' => 'icon-tags',
            'items' => [
                 ['title' => 'tags.manage', 'route' => 'reactor.tags.index', 'icon' => 'icon-tag']
            ]
        ],
        'documents' => [
            'title' => 'documents.title',
            'permission' => 'ACCESS_DOCUMENTS',
            'icon' => 'icon-docs',
            'items' => [
                ['title' => 'documents.manage', 'route' => 'reactor.documents.index', 'icon' => 'icon-folder-empty'],
                ['title' => 'documents.upload', 'route' => 'reactor.documents.upload', 'icon' => 'icon-upload-cloud', 'permission' => 'ACCESS_DOCUMENTS_UPLOAD'],
                ['title' => 'documents.embed', 'route' => 'reactor.documents.embed', 'icon' => 'icon-code', 'permission' => 'ACCESS_DOCUMENTS_UPLOAD']
            ]
        ],
        'users' => [
            'title' => 'users.title',
            'permission' => 'ACCESS_USERS',
            'icon' => 'icon-user',
            'items' => [
                ['title' => 'users.manage', 'route' => 'reactor.users.index', 'icon' => 'icon-user'],
                ['title' => 'users.manage_roles', 'route' => 'reactor.roles.index', 'icon' => 'icon-users', 'permission' => 'ACCESS_ROLES'],
                ['title' => 'users.manage_permissions', 'route' => 'reactor.permissions.index', 'icon' => 'icon-list', 'permission' => 'ACCESS_PERMISSIONS']
            ]
        ],
        'nodes' => [
            'title' => 'nodes.management',
            'permission' => 'ACCESS_NODES',
            'icon' => 'icon-flow-cascade',
            'items' => [
                ['title' => 'nodes.manage', 'route' => 'reactor.nodes.index', 'icon' => 'icon-flow-parallel']
            ]
        ]
    ];

    /**
     * Constructor
     *
     * @param Gate $gate
     */
    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Get main navigation items
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get main navigation items
     *
     * @param array $items
     * @return array
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * Adds a navigation module to main navigation items
     *
     * @param string $key
     * @param array $module
     */
    public function addModule($key, array $module)
    {
        $this->items[$key] = $module;
    }

    /**
     * Get final navigation items
     *
     * @return array
     */
    public function getFinalItems()
    {
        $items = $this->makeSettingGroupsList();
        array_unshift($items, ['title' => 'settings.all', 'route' => 'reactor.settings.group.edit', 'icon' => 'icon-cog-alt', 'permission' => 'ACCESS_SETTINGS_MODIFY']);
        array_push($items, ['title' => 'settings.manage', 'route' => 'reactor.settings.index', 'icon' => 'icon-tools']);
        array_push($items, ['title' => 'settings.manage_groups', 'route' => 'reactor.settinggroups.index', 'icon' => 'icon-list', 'permission' => 'ACCESS_SETTINGGROUPS']);

        return [
            'settings' => [
                'title' => 'settings.title',
                'permission' => 'ACCESS_SETTINGS',
                'icon' => 'icon-cog',
                'items' => $items
            ],
            'advanced' => [
                'title' => 'advanced.title',
                'permission' => 'ACCESS_ADVANCED',
                'icon' => 'icon-wrench',
                'items' => [
                    ['title' => 'advanced.manage', 'route' => 'reactor.advanced', 'icon' => 'icon-wrench'],
                    ['title' => 'advanced.update', 'route' => 'reactor.advanced.update', 'icon' => 'icon-arrows-cw']
                ]
            ]
        ];
    }

    /**
     * Returns html for given array
     *
     * @param array $list
     * @return string
     */
    public function makeNavigationFor(array $list)
    {
        $html = '';

        foreach ($list as $key => $navigation)
        {
            $html .= $this->makeNavigationModule($navigation);
        }

        return $html;
    }

    /**
     * Returns the html for given navigation set
     *
     * @param array $navigation
     * @return string
     */
    public function makeNavigationModule(array $navigation)
    {
        if (isset($navigation['permission']) && $this->gate->denies($navigation['permission']))
        {
            return '';
        }

        return $this->navigationModuleOpen($navigation['icon'], $navigation['title'])
            . $this->makeNavigationLinks($navigation['items'])
            . $this->navigationModuleClose();
    }

    /**
     * Returns the html for given item set
     *
     * @param array $items
     * @return string
     */
    public function makeNavigationLinks(array $items)
    {
        $html = '';

        foreach ($items as $item)
        {
            if ($item === 'splitter')
            {
                $html .= '<li class="options-splitter"></li>';
                continue;
            }

            if (isset($item['permission']) && $this->gate->denies($item['permission']))
            {
                continue;
            }

            $html .= $this->navigationModuleLink($item['route'], $item['icon'], $item['title'],
                (isset($item['options'])) ? $item['options'] : []);
        }

        return $html;
    }

    /**
     * Returns html for initial items
     *
     * @return string
     */
    public function makeMainNavigation()
    {
        return $this->makeNavigationFor(
            $this->getItems()
        );
    }

    /**
     * Returns html for final items
     *
     * @return string
     */
    public function makeFinalNavigation()
    {
        return $this->makeNavigationFor(
            $this->getFinalItems()
        );
    }

    /**
     * Creates an setting groups array
     *
     * @return array
     */
    protected function makeSettingGroupsList()
    {
        $groups = [];

        foreach(settings()->getGroups() as $key => $group)
        {
            $groups[] = ['title' => $group, 'route' => 'reactor.settings.group.edit', 'icon' => 'icon-blank', 'options' => $key];
        }

        return $groups;
    }

    /**
     * Snippet for generating navigation menu openings
     *
     * @param string $icon
     * @param string $title
     * @return string
     */
    public function navigationModuleOpen($icon, $title)
    {
        return sprintf('<li class="navigation-module">
            <i class="%s"></i>
            <div class="module-dropdown material-middle">
                <div class="module-info">%s</div>
                <ul class="module-sub">', $icon, uppercase(trans($title)));
    }

    /**
     * Snippet for generating navigation menu closings
     *
     * @return string
     */
    public function navigationModuleClose()
    {
        return '</ul></div></li>';
    }

    /**
     * Snippet for generating module links
     *
     * @param string $route
     * @param string $icon
     * @param string $title
     * @param mixed $parameters
     * @return string
     */
    public function navigationModuleLink($route, $icon, $title, $parameters = [])
    {
        return sprintf('<li><a href="%s"><i class="%s"></i>%s</a>',
            route($route, $parameters),
            $icon,
            trans($title)
        );
    }

}