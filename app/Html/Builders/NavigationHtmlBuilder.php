<?php

namespace Reactor\Html\Builders;


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
        'nodes' => [
            'title' => 'nodes.title',
            'permission' => 'ACCESS_NODES',
            'icon' => 'icon-node-tree',
            'items' => [
                ['title' => 'nodes.all_nodes', 'route' => 'reactor.nodes.index', 'icon' => 'icon-list-bullet'],
                ['title' => 'nodes.withheld_nodes', 'route' => 'reactor.nodes.index', 'icon' => 'icon-status-withheld', 'options' => ['f' => 'withheld']],
                ['title' => 'nodes.invisible_nodes', 'route' => 'reactor.nodes.index', 'icon' => 'icon-status-invisible', 'options' => ['f' => 'invisible']],
                'splitter',
                ['title' => 'nodetypes.index', 'route' => 'reactor.nodetypes.index', 'icon' => 'icon-list-types', 'permission' => 'ACCESS_NODETYPES'],
            ]
        ],
        'documents' => [
            'title' => 'documents.title',
            'permission' => 'ACCESS_DOCUMENTS',
            'icon' => 'icon-documents',
            'items' => [
                ['title' => 'documents.index', 'route' => 'reactor.documents.index', 'icon' => 'icon-folder'],
                ['title' => 'documents.upload', 'route' => 'reactor.documents.upload', 'icon' => 'icon-document-upload', 'permission' => 'EDIT_DOCUMENTS'],
                ['title' => 'documents.embed', 'route' => 'reactor.documents.embed', 'icon' => 'icon-document-embed', 'permission' => 'EDIT_DOCUMENTS'],
            ]
        ],
        'tags' => [
            'title' => 'tags.title',
            'permission' => 'ACCESS_TAGS',
            'icon' => 'icon-tags',
            'items' => [
                ['title' => 'tags.index', 'route' => 'reactor.tags.index', 'icon' => 'icon-tags'],
                ['title' => 'tags.create', 'route' => 'reactor.tags.create', 'icon' => 'icon-tag-create'],
            ]
        ],
        'mailings' => [
            'title' => 'mailings.title',
            'permission' => 'ACCESS_MAILINGS',
            'icon' => 'icon-envelope',
            'items' => [
                ['title' => 'mailings.index', 'route' => 'reactor.mailings.index', 'icon' => 'icon-envelopes'],
                ['title' => 'mailings.create', 'route' => 'reactor.mailings.create', 'icon' => 'icon-envelope'],
                ['title' => 'mailings.lists', 'route' => 'reactor.mailings.lists', 'icon' => 'icon-list-linear'],
            ]
        ],
        'users' => [
            'title' => 'users.title',
            'permission' => 'ACCESS_USERS',
            'icon' => 'icon-user',
            'items' => [
                ['title' => 'users.index', 'route' => 'reactor.users.index', 'icon' => 'icon-users'],
                ['title' => 'users.create', 'route' => 'reactor.users.create', 'icon' => 'icon-user-create', 'permission' => 'ACCESS_'],
                'splitter',
                ['title' => 'roles.index', 'route' => 'reactor.roles.index', 'icon' => 'icon-user-role', 'permission' => 'ACCESS_ROLES'],
                ['title' => 'permissions.index', 'route' => 'reactor.permissions.index', 'icon' => 'icon-user-permission', 'permission' => 'ACCESS_PERMISSIONS'],
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
        return [
            'maintenance' => [
                'title' => 'maintenance.title',
                'permission' => 'ACCESS_MAINTENANCE',
                'icon' => 'icon-wrench',
                'items' => [
                    ['title' => 'maintenance.index', 'route' => 'reactor.maintenance.index', 'icon' => 'icon-wrench'],
                    ['title' => 'update.index', 'route' => 'reactor.update.index', 'icon' => 'icon-sync'],
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
                $html .= '<li class="dropdown-sub__splitter navigation-module-sub__splitter"></li>';
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
     * Snippet for generating navigation menu openings
     *
     * @param string $icon
     * @param string $title
     * @return string
     */
    public function navigationModuleOpen($icon, $title)
    {
        return sprintf('<li class="navigation-module has-dropdown" data-hover="true">
            <i class="navigation-module__icon dropdown-icon %s"></i>
            <div class="dropdown navigation-module__dropdown">
                <div class="dropdown__info navigation-module__info">%s</div>
                <ul class="dropdown-sub navigation-module-sub">', $icon, uppercase(trans($title)));
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
        return sprintf('<li class="dropdown-sub__item navigation-module-sub__item"><a href="%s"><i class="%s"></i>%s</a>',
            route($route, $parameters),
            $icon,
            trans($title)
        );
    }

}