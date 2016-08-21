<?php


namespace Reactor\Providers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationRulesServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (['NotReservedName'] as $rule)
        {
            $this->{'register' . $rule . 'Rule'}();
        }
    }

    /**
     * Register not reserved field rule
     *
     * @return void
     */
    protected function registerNotReservedNameRule()
    {
        Validator::extend('not_reserved_name', function ($attribute, $value, $parameters, $validator)
        {
            $reservedFields = ['id', 'node_id', 'locale', 'source_type',
                'node_type_id', 'user_id', 'parent_id', '_lft', '_rgt', 'title', 'node_name',
                'meta_title', 'meta_keywords', 'meta_description', 'meta_image', 'meta_author',
                'visible', 'sterile', 'home', 'locked', 'status', 'hides_children', 'priority',
                'published_at', 'children_order', 'children_order_direction', 'children_display_mode',
                'created_at', 'updated_at',
                'tags', 'nodeType', 'translations', 'children', 'source', 'tempSource',
                'fillable', 'translatedAttributes', 'dates', 'translationModel', 'sourcesTable',
                'localeKey', 'nodeTypeKey', 'searchable', 'table', 'sortableColumns', 'sortableKey',
                'sortableDirection', 'specialSortableKeys', 'owner', 'trackerViews'
            ];

            return ! in_array($value, $reservedFields);
        });
    }

}