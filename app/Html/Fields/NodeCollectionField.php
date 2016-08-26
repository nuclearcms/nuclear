<?php


namespace Reactor\Html\Fields;


use Kris\LaravelFormBuilder\Fields\FormField;

class NodeCollectionField extends FormField {

    /**
     * Get the template, can be config variable or view path
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'fields.relation';
    }

    /**
     * @param array $options
     * @param bool  $showLabel
     * @param bool  $showField
     * @param bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['mode'] = 'multiple';
        $options['getter_method'] = 'get_nodes_by_ids';
        $options['getter_method_params'] = [false];
        $options['search_route'] = 'reactor.nodes.search.json';

        return parent::render($options, $showLabel, $showField, $showError);
    }

}