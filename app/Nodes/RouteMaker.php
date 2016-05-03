<?php

namespace Reactor\Nodes;


class RouteMaker {

    /** @var string */
    protected $route;

    /** @var string */
    protected $routeName;

    /** @var array */
    protected $parameters = null;

    /** @var Node */
    protected $node;

    /**
     * Constructor
     *
     * @param string $route
     * @param Node $node
     */
    public function __construct($route, Node $node)
    {
        $this->route = $route;
        $this->node = $node;
    }

    /**
     * Getter for route name
     *
     * @return string
     */
    public function getRouteName()
    {
        if (is_null($this->parameters))
        {
            $this->compileParameters();
        }

        return $this->routeName;
    }

    /**
     * Getter for Node route parameters
     *
     * @param array $additionalParameters
     * @return array
     */
    public function getRouteParameters($additionalParameters = [])
    {
        if (is_null($this->parameters))
        {
            $this->compileParameters();
        }

        return array_merge($this->parameters, $additionalParameters);
    }

    /**
     * Makes the url for given route
     * 
     * @param array $additionalParameters
     * @return string
     */
    public function makeRouteURL($additionalParameters = [])
    {
        return route($this->getRouteName(), $this->getRouteParameters($additionalParameters));
    }
    
    /**
     * Compiles the route parameters from a Node
     */
    protected function compileParameters()
    {
        $parameters = $this->extractRouteParameters();

        foreach ($parameters as $parameter)
        {
            $this->parameters[] = $this->getNodeParameter($parameter, $this->node);
        }
    }

    /**
     * Extracts route parameters
     *
     * @return array
     */
    protected function extractRouteParameters()
    {
        $parameters = explode(':', $this->route);

        $this->routeName = array_shift($parameters);

        $parameters = end($parameters);

        return explode('/', $parameters);
    }

    /**
     * Gets a parameter from a Node
     *
     * @param string $parameter
     * @param Node $node
     * @return mixed
     */
    protected function getNodeParameter($parameter, Node $node)
    {
        $parameters = explode('.', $parameter);

        $parameter = $node;

        foreach ($parameters as $key)
        {
            $parameter = $parameter->{$key};
        }

        return $parameter;
    }

}