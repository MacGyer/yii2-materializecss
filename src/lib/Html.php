<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\lib;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\validators\StringValidator;

/**
 * Html is the individual HTML helper implementation.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package lib
 */
class Html extends BaseHtml
{
    /**
     * Generates a text input tag for the given model attribute.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\BaseHtml::getAttributeName()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#getAttributeName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     * See [\yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     * The following special options are recognized:
     *
     * - maxlength: integer|boolean, when `maxlength` is set true and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     *   The `length` option is required by the Materialize JS plugin `characterCounter()`.
     *
     * @return string the generated input tag
     */
    public static function activeTextInput($model, $attribute, $options = [])
    {
        self::normalizeMaxLength($model, $attribute, $options);
        return static::activeInput('text', $model, $attribute, $options);
    }

    /**
     * Generates a password input tag for the given model attribute.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\BaseHtml::getAttributeName()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#getAttributeName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     * See [\yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     * The following special options are recognized:
     *
     * - maxlength: integer|boolean, when `maxlength` is set true and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     *   The `length` option is required by the Materialize JS plugin `characterCounter()`.
     *
     * @return string the generated input tag
     */
    public static function activePasswordInput($model, $attribute, $options = [])
    {
        self::normalizeMaxLength($model, $attribute, $options);
        return static::activeInput('password', $model, $attribute, $options);
    }

    /**
     * Generates a textarea tag for the given model attribute.
     * The model attribute value will be used as the content in the textarea.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\BaseHtml::getAttributeName()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#getAttributeName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     * See [\yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     * The following special options are recognized:
     *
     * - maxlength: integer|boolean, when `maxlength` is set true and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail)
     *   The `length` option is required by the Materialize JS plugin `characterCounter()`.
     *
     * @return string the generated textarea tag
     */
    public static function activeTextarea($model, $attribute, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        if (isset($options['value'])) {
            $value = $options['value'];
            unset($options['value']);
        } else {
            $value = static::getAttributeValue($model, $attribute);
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }
        self::normalizeMaxLength($model, $attribute, $options);
        return static::textarea($name, $value, $options);
    }

    /**
     * If `maxlength` option is set true and the model attribute is validated by a string validator,
     * the `maxlength` option will take the value of [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail). Additionally the
     * `length` property is populated with the same value, to enable the Materialize character counter.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @see http://materializecss.com/forms.html#character-counter
     */
    private static function normalizeMaxLength($model, $attribute, &$options)
    {
        if (isset($options['maxlength']) && $options['maxlength'] === true) {
            unset($options['maxlength']);
            $showCharacterCounter = ArrayHelper::remove($options, 'showCharacterCounter', false);

            $attrName = static::getAttributeName($attribute);
            foreach ($model->getActiveValidators($attrName) as $validator) {
                if ($validator instanceof StringValidator && $validator->max !== null) {
                    $options['maxlength'] = $validator->max;

                    if ($showCharacterCounter === true) {
                        $options['data-length'] = $validator->max;
                    }
                    break;
                }
            }
        }
    }

    /**
     * Generates a radio button tag together with a label for the given model attribute.
     * This method will generate the "checked" tag attribute according to the model attribute value.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     *
     * @return string the generated radio button tag
     */
    public static function activeRadio($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('radio', $model, $attribute, $options);
    }

    /**
     * Generates a checkbox tag together with a label for the given model attribute.
     * This method will generate the "checked" tag attribute according to the model attribute value.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     *
     * @return string the generated checkbox tag
     */
    public static function activeCheckbox($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('checkbox', $model, $attribute, $options);
    }

    /**
     * Generates a boolean input
     * This method is mainly called by [[activeCheckbox()]] and [[activeRadio()]].
     * @param string $type the input type. This can be either `radio` or `checkbox`.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     * @return string the generated input element
     * @since 2.0.9
     */
    protected static function activeBooleanInput($type, $model, $attribute, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $value = static::getAttributeValue($model, $attribute);

        if (!array_key_exists('value', $options)) {
            $options['value'] = '1';
        }
        if (!array_key_exists('uncheck', $options)) {
            $options['uncheck'] = '0';
        } elseif ($options['uncheck'] === false) {
            unset($options['uncheck']);
        }
        if (!array_key_exists('label', $options)) {
            $options['label'] = static::encode($model->getAttributeLabel(static::getAttributeName($attribute)));
        } elseif ($options['label'] === false) {
            unset($options['label']);
        }

        if (isset($options['label'])) {
            $options['label'] = '<span>' . $options['label'] . '</span>';
        }

        $checked = "$value" === "{$options['value']}";

        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        return static::$type($name, $checked, $options);
    }

    /**
     * Generates a list of checkboxes. A checkbox list allows multiple selection.
     * As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $items the data item used to generate the checkboxes.
     * The array keys are the checkbox values, and the array values are the corresponding labels.
     * Note that the labels will NOT be HTML-encoded, while the values will.
     * @param array $options options (name => config) for the checkbox list container tag.
     * The following options are specially handled:
     *
     * - tag: string|false, the tag name of the container element. False to render checkbox without container.
     *   See also [\yii\helpers\Html::tag()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#tag()-detail).
     * - unselect: string, the value that should be submitted when none of the checkboxes is selected.
     *   You may set this option to be null to prevent default value submission.
     *   If this option is not set, an empty string will be submitted.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox tag using [\yii\helpers\Html::checkbox()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#checkbox()-detail).
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ```php
     *   function ($index, $label, $name, $checked, $value)
     *   ```
     *
     *   where $index is the zero-based index of the checkbox in the whole list; $label
     *   is the label for the checkbox; and $name, $value and $checked represent the name,
     *   value and the checked status of the checkbox input.
     *
     * See [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#renderTagAttributes()-detail) for details on how attributes are being rendered.
     *
     * @return string the generated checkbox list
     */
    public static function activeCheckboxList($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('checkboxList', $model, $attribute, $items, $options);
    }

    /**
     * Generates a list of radio buttons.
     * A radio button list is like a checkbox list, except that it only allows single selection.
     * The selection of the radio buttons is taken from the value of the model attribute.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $items the data item used to generate the radio buttons.
     * The array keys are the radio values, and the array values are the corresponding labels.
     * Note that the labels will NOT be HTML-encoded, while the values will.
     * @param array $options options (name => config) for the radio button list container tag.
     * The following options are specially handled:
     *
     * - tag: string|false, the tag name of the container element. False to render radio button without container.
     *   See also [\yii\helpers\Html::tag()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#tag()-detail).
     * - unselect: string, the value that should be submitted when none of the radio buttons is selected.
     *   You may set this option to be null to prevent default value submission.
     *   If this option is not set, an empty string will be submitted.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the radio button tag using [[radio()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ```php
     *   function ($index, $label, $name, $checked, $value)
     *   ```
     *
     *   where $index is the zero-based index of the radio button in the whole list; $label
     *   is the label for the radio button; and $name, $value and $checked represent the name,
     *   value and the checked status of the radio button input.
     *
     * See [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#renderTagAttributes()-detail) for details on how attributes are being rendered.
     *
     * @return string the generated radio button list
     */
    public static function activeRadioList($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('radioList', $model, $attribute, $items, $options);
    }

    /**
     * Generates a list of input fields.
     * This method is mainly called by [[activeRadioList()]] and [[activeCheckboxList()]].
     * @param string $type the input type. This can be 'radioList' or 'checkBoxList'.
     * @param Model $model the model object
     * @param string $attribute the attribute name or expression. See [\yii\helpers\Html::getAttributeName()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#getInputName()-detail) for the format
     * about attribute expression.
     * @param array $items the data item used to generate the input fields.
     * The array keys are the input values, and the array values are the corresponding labels.
     * Note that the labels will NOT be HTML-encoded, while the values will.
     * @param array $options options (name => config) for the input list. The supported special options
     * depend on the input type specified by `$type`.
     * @return string the generated input list
     */
    protected static function activeListInput($type, $model, $attribute, $items, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        $selection = isset($options['value']) ? $options['value'] : static::getAttributeValue($model, $attribute);
        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        return static::$type($name, $selection, $items, $options);
    }

    /**
     * Generates a list of checkboxes. A checkbox list allows multiple selection.
     * As a result, the corresponding submitted value is an array.
     * @param string $name the name attribute of each checkbox.
     * @param string|array|null $selection the selected value(s). String for single or array for multiple selection(s).
     * @param array $items the data item used to generate the checkboxes.
     * The array keys are the checkbox values, while the array values are the corresponding labels.
     * @param array $options options (name => config) for the checkbox list container tag.
     * The following options are specially handled:
     *
     * - tag: string|false, the tag name of the container element. False to render checkbox without container.
     *   See also [\yii\helpers\Html::tag()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#tag()-detail).
     * - unselect: string, the value that should be submitted when none of the checkboxes is selected.
     *   By setting this option, a hidden input will be generated.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the checkbox tag using [\yii\helpers\Html::checkbox()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#checkbox()-detail).
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ```php
     *   function ($index, $label, $name, $checked, $value)
     *   ```
     *
     *   where $index is the zero-based index of the checkbox in the whole list; $label
     *   is the label for the checkbox; and $name, $value and $checked represent the name,
     *   value and the checked status of the checkbox input, respectively.
     *
     * See [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#renderTagAttributes()-detail) for details on how attributes are being rendered.
     *
     * @return string the generated checkbox list
     */
    public static function checkboxList($name, $selection = null, $items = [], $options = [])
    {
        if (substr($name, -2) !== '[]') {
            $name .= '[]';
        }
        if (ArrayHelper::isTraversable($selection)) {
            $selection = array_map('strval', (array)$selection);
        }

        $formatter = ArrayHelper::remove($options, 'item');
        $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
        $encode = ArrayHelper::remove($options, 'encode', true);
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (!ArrayHelper::isTraversable($selection) && !strcmp($value, $selection)
                    || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string)$value, $selection));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $name, $checked, $value);
            } else {
                $lines[] = Html::tag('div', static::checkbox($name, $checked, array_merge($itemOptions, [
                    'value' => $value,
                    'label' => $encode ? static::encode($label) : $label,
                ])));
            }
            $index++;
        }

        if (isset($options['unselect'])) {
            // add a hidden field so that if the list box has no option being selected, it still submits a value
            $name2 = substr($name, -2) === '[]' ? substr($name, 0, -2) : $name;
            $hidden = static::hiddenInput($name2, $options['unselect']);
            unset($options['unselect']);
        } else {
            $hidden = '';
        }

        $visibleContent = implode($separator, $lines);

        if ($tag === false) {
            return $hidden . $visibleContent;
        }

        return $hidden . static::tag($tag, $visibleContent, $options);
    }

    /**
     * Generates a list of radio buttons.
     * A radio button list is like a checkbox list, except that it only allows single selection.
     * @param string $name the name attribute of each radio button.
     * @param string|array|null $selection the selected value(s). String for single or array for multiple selection(s).
     * @param array $items the data item used to generate the radio buttons.
     * The array keys are the radio button values, while the array values are the corresponding labels.
     * @param array $options options (name => config) for the radio button list container tag.
     * The following options are specially handled:
     *
     * - tag: string|false, the tag name of the container element. False to render radio buttons without container.
     *   See also [\yii\helpers\Html::tag()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#tag()-detail).
     * - unselect: string, the value that should be submitted when none of the radio buttons is selected.
     *   By setting this option, a hidden input will be generated.
     * - encode: boolean, whether to HTML-encode the checkbox labels. Defaults to true.
     *   This option is ignored if `item` option is set.
     * - separator: string, the HTML code that separates items.
     * - itemOptions: array, the options for generating the radio button tag using [[radio()]].
     * - item: callable, a callback that can be used to customize the generation of the HTML code
     *   corresponding to a single item in $items. The signature of this callback must be:
     *
     *   ```php
     *   function ($index, $label, $name, $checked, $value)
     *   ```
     *
     *   where $index is the zero-based index of the radio button in the whole list; $label
     *   is the label for the radio button; and $name, $value and $checked represent the name,
     *   value and the checked status of the radio button input, respectively.
     *
     * See [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#renderTagAttributes()-detail) for details on how attributes are being rendered.
     *
     * @return string the generated radio button list
     */
    public static function radioList($name, $selection = null, $items = [], $options = [])
    {
        if (ArrayHelper::isTraversable($selection)) {
            $selection = array_map('strval', (array)$selection);
        }

        $formatter = ArrayHelper::remove($options, 'item');
        $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
        $encode = ArrayHelper::remove($options, 'encode', true);
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        // add a hidden field so that if the list box has no option being selected, it still submits a value
        $hidden = isset($options['unselect']) ? static::hiddenInput($name, $options['unselect']) : '';
        unset($options['unselect']);

        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (!ArrayHelper::isTraversable($selection) && !strcmp($value, $selection)
                    || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn((string)$value, $selection));
            if ($formatter !== null) {
                $lines[] = call_user_func($formatter, $index, $label, $name, $checked, $value);
            } else {
                $lines[] = Html::tag('div', static::radio($name, $checked, array_merge($itemOptions, [
                    'value' => $value,
                    'label' => $encode ? static::encode($label) : $label,
                ])));
            }
            $index++;
        }
        $visibleContent = implode($separator, $lines);

        if ($tag === false) {
            return $hidden . $visibleContent;
        }

        return $hidden . static::tag($tag, $visibleContent, $options);
    }

    /**
     * Generates a radio button input.
     * @param string $name the name attribute.
     * @param bool $checked whether the radio button should be checked.
     * @param array $options the tag options in terms of name-value pairs.
     * See [[booleanInput()]] for details about accepted attributes.
     *
     * @return string the generated radio button tag
     */
    public static function radio($name, $checked = false, $options = [])
    {
        return static::booleanInput('radio', $name, $checked, $options);
    }

    /**
     * Generates a boolean input.
     * @param string $type the input type. This can be either `radio` or `checkbox`.
     * @param string $name the name attribute.
     * @param bool $checked whether the checkbox should be checked.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - uncheck: string, the value associated with the uncheck state of the checkbox. When this attribute
     *   is present, a hidden input will be generated so that if the checkbox is not checked and is submitted,
     *   the value of this attribute will still be submitted to the server via the hidden input.
     * - label: string, a label displayed next to the checkbox.  It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is is coming from end users, you should [\yii\helpers\Html::encode()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#encode()-detail) it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag.
     * - labelOptions: array, the HTML attributes for the label tag. Do not set this option unless you set the "label" option.
     *
     * The rest of the options will be rendered as the attributes of the resulting checkbox tag. The values will
     * be HTML-encoded using [\yii\helpers\Html::encode()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#encode()-detail). If a value is null, the corresponding attribute will not be rendered.
     * See [\yii\helpers\Html::renderTagAttributes()](https://www.yiiframework.com/doc/api/2.0/yii-helpers-basehtml#renderTagAttributes()-detail) for details on how attributes are being rendered.
     *
     * @return string the generated checkbox tag
     * @since 2.0.9
     */
    protected static function booleanInput($type, $name, $checked = false, $options = [])
    {
        $options['checked'] = (bool) $checked;
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            $hidden = static::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }
        if (isset($options['label'])) {
            $label = Html::tag('span', $options['label']);
            $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : [];
            unset($options['label'], $options['labelOptions']);
            $content = static::label(static::input($type, $name, $value, $options) . ' ' . $label, null, $labelOptions);
            return $hidden . $content;
        }

        return $hidden . static::input($type, $name, $value, $options);
    }

    public static function error($model, $attribute, $options = [])
    {
        $attribute = static::getAttributeName($attribute);
        $errorSource = ArrayHelper::remove($options, 'errorSource');
        if ($errorSource !== null) {
            $error = call_user_func($errorSource, $model, $attribute);
        } else {
            $error = $model->getFirstError($attribute);
        }
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        $encode = ArrayHelper::remove($options, 'encode', true);

        $options['data-error'] = $error;
        return Html::tag($tag, $encode ? Html::encode($error) : $error, $options);
    }
}
