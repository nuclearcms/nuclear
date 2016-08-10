<?php


namespace Reactor\Http\Controllers;


abstract class ReactorController extends Controller {

    /**
     * Compiles view for display
     *
     * @param string $view
     * @param array $parameters
     * @param string $title
     * @return view
     */
    protected function compileView($view, array $parameters = [], $title = null)
    {
        $parameters['pageTitle'] = ($title ?: trans($view));

        return view($view, $parameters);
    }

}