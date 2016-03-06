<?php

namespace macgyer\yii2materializecss\widgets\data;

/**
 * Class DetailView
 * @package macgyer\yii2materializecss\widgets\data
 */
class DetailView extends \yii\widgets\DetailView
{
    /**
     * @var array|object the data model whose details are to be displayed. This can be a [[Model]] instance,
     * an associative array, an object that implements [[Arrayable]] interface or simply an object with defined
     * public accessible non-static properties.
     */
    public $model;

    /**
     * @var array a list of attributes to be displayed in the detail view. Each array element
     * represents the specification for displaying one particular attribute.
     *
     * An attribute can be specified as a string in the format of "attribute", "attribute:format" or "attribute:format:label",
     * where "attribute" refers to the attribute name, and "format" represents the format of the attribute. The "format"
     * is passed to the [[Formatter::format()]] method to format an attribute value into a displayable text.
     * Please refer to [[Formatter]] for the supported types. Both "format" and "label" are optional.
     * They will take default values if absent.
     *
     * An attribute can also be specified in terms of an array with the following elements:
     *
     * - attribute: the attribute name. This is required if either "label" or "value" is not specified.
     * - label: the label associated with the attribute. If this is not specified, it will be generated from the attribute name.
     * - value: the value to be displayed. If this is not specified, it will be retrieved from [[model]] using the attribute name
     *   by calling [[ArrayHelper::getValue()]]. Note that this value will be formatted into a displayable text
     *   according to the "format" option.
     * - format: the type of the value that determines how the value would be formatted into a displayable text.
     *   Please refer to [[Formatter]] for supported types.
     * - visible: whether the attribute is visible. If set to `false`, the attribute will NOT be displayed.
     */
    public $attributes;

    /**
     * @var string|callable the template used to render a single attribute. If a string, the token `{label}`
     * and `{value}` will be replaced with the label and the value of the corresponding attribute.
     * If a callback (e.g. an anonymous function), the signature must be as follows:
     *
     * ```php
     * function ($attribute, $index, $widget)
     * ```
     *
     * where `$attribute` refer to the specification of the attribute being rendered, `$index` is the zero-based
     * index of the attribute in the [[attributes]] array, and `$widget` refers to this widget instance.
     */
    public $template = '<tr><th>{label}</th><td>{value}</td></tr>';

    /**
     * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
     * what container tag should be used. It defaults to "table" if not set.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'table striped bordered detail-view'];

    /**
     * @var array|Formatter the formatter used to format model attribute values into displayable texts.
     * This can be either an instance of [[Formatter]] or an configuration array for creating the [[Formatter]]
     * instance. If this property is not set, the "formatter" application component will be used.
     */
    public $formatter;
}
