<?php

namespace Reactor\Providers;


use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationRulesServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (['UniqueSetting', 'UniqueSettingGroup', 'DateMysql', 'NotReservedField'] as $rule)
        {
            $this->{'register' . $rule . 'Rule'}();
        }
    }

    /**
     * Register unique setting rule
     *
     * @return void
     */
    protected function registerUniqueSettingRule()
    {
        Validator::extend('unique_setting', function ($attribute, $value, $parameters, $validator)
        {
            if (isset($parameters[0]) && $value === $parameters[0])
            {
                return true;
            }

            return ! settings()->has($value);
        });
    }

    /**
     * Register unique setting group rule
     *
     * @return void
     */
    protected function registerUniqueSettingGroupRule()
    {

        Validator::extend('unique_setting_group', function ($attribute, $value, $parameters, $validator)
        {
            if (isset($parameters[0]) && $value === $parameters[0])
            {
                return true;
            }

            return ! settings()->hasGroup($value);
        });
    }

    /**
     * Register mysql date rule
     *
     * @return void
     */
    protected function registerDateMysqlRule()
    {
        Validator::extend('date_mysql', function ($attribute, $value, $parameters, $validator)
        {
            if (DateTime::createFromFormat('Y-m-d H:i:s', $value))
            {
                return true;
            }

            return false;
        });
    }

    /**
     * Register not reserved field rule
     *
     * @return void
     */
    protected function registerNotReservedFieldRule()
    {
        Validator::extend('not_reserved_field', function ($attribute, $value, $parameters, $validator)
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