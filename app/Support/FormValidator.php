<?php


namespace Reactor\Support;


class FormValidator {

    /**
     * Validates the given value is not a reserved name
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateNotReservedName($attribute, $value, $parameters, $validator)
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
    }

    /**
     * Validates the given value is valid MySQL date
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validateDateMysql($attribute, $value, $parameters, $validator)
    {
        if (\DateTime::createFromFormat('Y-m-d H:i:s', $value))
        {
            return true;
        }

        return false;
    }

}