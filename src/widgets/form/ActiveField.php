<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

// TODO: range with noUiSlider --> own widget
// TODO: checkbox list
// TODO: radio list
// TODO: select ?
// TODO: file input


/**
 * ActiveField represents a form input field within an [yii\widgets\ActiveForm](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html).
 * @see http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @var array the HTML attributes (name-value pairs) for the field container tag.
     * The values will be HTML-encoded using [Html::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     * If a value is null, the corresponding attribute will not be rendered.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     *
     * If you set a custom `id` for the container element, you may need to adjust the [$selectors](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#$selectors-detail) accordingly.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $options = ['class' => 'input-field'];

    /**
     * @var string the template that is used to arrange the label, the input field, the error message and the hint text.
     * The following tokens will be replaced when [[render()]] is called: `{label}`, `{input}`, `{error}` and `{hint}`.
     */
    public $template = "{icon}\n{input}\n{label}\n{hint}\n{error}";

    /**
     * @var array the default options for the input tags. The parameter passed to individual input methods
     * (e.g. [textInput()](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#textInput()-detail)) will be merged with this property when rendering the input tag.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [$selectors](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#$selectors-detail) accordingly.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $inputOptions = [];

    /**
     * @var array the default options for the error tags. The parameter passed to [yii\widgets\ActiveField::error()](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#error()-detail) will be
     * merged with this property when rendering the error tag.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     * - encode: whether to encode the error output. Defaults to true.
     *
     * If you set a custom `id` for the error element, you may need to adjust the [yii\widgets\ActiveField::$selectors](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#$selectors-detail) accordingly.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $errorOptions = ['class' => 'help-block'];

    /**
     * @var array the default options for the label tags. The parameter passed to [label()](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#label()-detail) will be
     * merged with this property when rendering the label tag.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $labelOptions = [];

    /**
     * @var array the default options for the hint tags. The parameter passed to [yii\widgets\ActiveField::hint()](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#hint()-detail) will be
     * merged with this property when rendering the hint tag.
     * The following special options are recognized:
     *
     * - tag: the tag name of the container element. Defaults to "div".
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $hintOptions = ['class' => 'hint-block'];

    /**
     * @var array the options for the optional prefix icon.
     *
     * To specify an icon you can use the following parameters
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // required
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     * @see Icon|Icon
     */
    public $icon;

    /**
     * @var boolean whether to show a character counter.
     * This is only effective when `maxlength` option is set true and the model attribute is validated
     * by a string validator. The `maxlength` and `length` option then will both take the value of
     * [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     *
     * Note: the `characterCounter()` is currently available for input types `text` and `password`, and for `textarea`.
     *
     * @see http://materializecss.com/forms.html#character-counter
     */
    public $showCharacterCounter = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if ($this->form->enableClientScript === true && $this->form->enableClientValidation === true) {
            Html::addCssClass($this->inputOptions, ['inputValidation' => 'validate']);
        }

        if ($this->showCharacterCounter === true) {
            $this->inputOptions['showCharacterCounter'] = true;
        }
    }

    /**
     * Initializes the Materialize autocomplete feature.
     *
     * @param array $options the tag options as name-value-pairs.
     * To use the Materialize autocomplete feature, set the option key `autocomplete` to an array.
     * The array keys are the strings to be matched and the values are optional image URLs. If an image URL is provided,
     * a thumbnail is shown next to the string in the autocomplete suggestion list:
     *
     * ```php
     * ...
     * 'autocomplete' => [
     *     'George' => 'http://lorempixel.com/40/40/people',
     *     'Fiona' => null     // no thumbnail
     * ],
     * ...
     * ```
     *
     * To use the HTML5 autocomplete feature, set this option to `on`. To explicitely disable the HTML5 autocomplete, set
     * this option to `off`. Either `on` or `off` disables the Materialize autocomplete feature.
     *
     * @see http://materializecss.com/forms.html#autocomplete
     */
    protected function initAutoComplete(&$options = [])
    {
        $autocomplete = ArrayHelper::getValue($options, 'autocomplete', []);

        // not Materialize autocomplete structure
        if (!is_array($autocomplete) || empty($autocomplete)) {
            return;
        }

        ArrayHelper::remove($options, 'autocomplete');

        $view = $this->form->getView();
        Html::addCssClass($options, ['autocomplete' => 'has-autocomplete']);

        MaterializePluginAsset::register($view);
        $autocompleteData['data'] = $autocomplete;

        $pluginOptions = Json::htmlEncode($autocompleteData);
        $js = "$('input.has-autocomplete').autocomplete($pluginOptions);";

        $view->registerJs($js);
    }

    /**
     * Renders the whole field.
     * This method will generate the label, error tag, input tag and hint tag (if any), and
     * assemble them into HTML according to [[template]].
     * @param string|callable $content the content within the field container.
     * If null (not set), the default methods will be called to generate the label, error tag and input tag,
     * and use them as the content.
     * If a callable, it will be called to generate the content. The signature of the callable should be:
     *
     * ```php
     * function ($field) {
     *     return $html;
     * }
     * ```
     *
     * @return string the rendering result
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{icon}'])) {
                $this->icon();
            }
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * Renders an icon.
     * @return ActiveField the field itself.
     * @throws \Exception
     */
    public function icon()
    {
        if ($this->icon === null) {
            $this->parts['{icon}'] = '';
            return $this;
        }

        $this->parts['{icon}'] = Icon::widget([
            'name' => ArrayHelper::getValue($this->icon, 'name', null),
            'position' => 'prefix',
            'options' => ArrayHelper::getValue($this->icon, 'options', [])
        ]);

        return $this;
    }

    /**
     * Renders a checkbox.
     * @param array $options the tag options in terms of name-value pairs. See parent class for more details.
     * @param bool $enclosedByLabel whether to enclose the checkbox within the label. This defaults to `false` as it is
     * Materialize standard to not wrap the checkboxes in labels.
     * @return $this
     */
    public function checkbox($options = [], $enclosedByLabel = false)
    {
        Html::addCssClass($this->options, ['class' => 'checkbox']);
        return parent::checkbox($options, $enclosedByLabel);
    }

    /**
     * Renders a drop-down list.
     *
     * @param array $items the option data items
     * @param array $options the tag options in terms of name-value pairs.
     *
     * @return $this the field object itself.
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html#dropDownList()-detail
     */
    public function dropDownList($items, $options = [])
    {
        $view = $this->form->view;
        MaterializePluginAsset::register($view);
        $id = $this->getInputId();

        $js = "$('#$id').material_select()";
        $view->registerJs($js);

        return parent::dropDownList($items, $options);
    }

    /**
     * Renders a radio button.
     * @param array $options the tag options in terms of name-value pairs. See parent class for more details.
     * @param bool $enclosedByLabel whether to enclose the checkbox within the label. This defaults to `false` as it is
     * Materialize standard to not wrap the checkboxes in labels.
     * @return $this
     */
    public function radio($options = [], $enclosedByLabel = false)
    {
        Html::addCssClass($this->options, ['class' => 'radio']);
        return parent::radio($options, $enclosedByLabel);
    }

    /**
     * Renders a color input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function colorInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'color']);
        $this->initAutoComplete($options);

        return parent::input('color', $options);
    }

    /**
     * Renders a date input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function dateInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'date']);
        $this->initAutoComplete($options);

        return parent::input('date', $options);
    }

    /**
     * Renders a datetime input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function datetimeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'datetime']);
        $this->initAutoComplete($options);

        return parent::input('datetime', $options);
    }

    /**
     * Renders a datetime local input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function datetimeLocalInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'datetime-local']);
        $this->initAutoComplete($options);

        return parent::input('datetime-local', $options);
    }

    /**
     * Renders an email input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function emailInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'email']);
        $this->initAutoComplete($options);

        return parent::input('email', $options);
    }

    /**
     * Renders a month input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function monthInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'month']);
        $this->initAutoComplete($options);

        return parent::input('month', $options);
    }

    /**
     * Renders a number input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function numberInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'number']);
        $this->initAutoComplete($options);

        return parent::input('number', $options);
    }

    /**
     * Renders a password input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - `maxlength`: integer|boolean, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both option will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     * - `showCharacterCounter`: boolean, when this option is set `true` and the `maxlength` option is set accordingly
     *   the Materialize character counter JS plugin is initialized for this field.
     *
     * @return $this the field object itself.
     * @see http://materializecss.com/forms.html#character-counter
     */
    public function passwordInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activePasswordInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders a range input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * @return ActiveField the field itself.
     */
    public function rangeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'range']);
        return parent::input('range', $options);
    }

    /**
     * Renders a search input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function searchInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'search']);
        $this->initAutoComplete($options);

        return parent::input('search', $options);
    }

    /**
     * Renders a phone input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function telInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'tel']);
        $this->initAutoComplete($options);

        return parent::input('tel', $options);
    }

    /**
     * Renders a text input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - `maxlength`: integer|boolean, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both option will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     * - `showCharacterCounter`: boolean, when this option is set `true` and the `maxlength` option is set accordingly
     *   the Materialize character counter JS plugin is initialized for this field.
     * - autocomplete: string|array, see [[initAutoComplete()]] for details
     *
     * @return $this the field object itself.
     * @see http://materializecss.com/forms.html#character-counter
     * @see http://materializecss.com/forms.html#autocomplete
     * @see https://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    public function textInput($options = [])
    {
        $this->initAutoComplete($options);
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders a textarea.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - `maxlength`: integer|boolean, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` and `length` option both option will take the value of
     *   [\yii\validators\StringValidator::max](http://www.yiiframework.com/doc-2.0/yii-validators-stringvalidator.html#$max-detail).
     * - `showCharacterCounter`: boolean, when this option is set `true` and the `maxlength` option is set accordingly
     *   the Materialize character counter JS plugin is initialized for this field.
     * - autocomplete: string|array, see [[initAutoComplete()]] for details
     *
     * @return $this the field object itself.
     * @see http://materializecss.com/forms.html#character-counter
     * @see http://materializecss.com/forms.html#autocomplete
     * @see https://www.w3.org/TR/html5/forms.html#attr-fe-autocomplete
     */
    public function textarea($options = [])
    {
        $this->initAutoComplete($options);
        Html::addCssClass($options, ['textarea' => 'materialize-textarea']);
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders a time input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function timeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'time']);
        $this->initAutoComplete($options);

        return parent::input('time', $options);
    }

    /**
     * Renders an URL input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function urlInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'url']);
        $this->initAutoComplete($options);

        return parent::input('url', $options);
    }

    /**
     * Renders a week input.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [\yii\helpers\BaseHtml::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#encode()-detail).
     *
     * The following special options are recognized:
     *
     * - autocomplete: string|array, see [[initAutoComplete()]] for details.
     * @return ActiveField the field itself.
     */
    public function weekInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'week']);
        $this->initAutoComplete($options);

        return parent::input('week', $options);
    }

    /**
     * Builds a radio list
     */
//    public function radioList($items, $options = [])
//    {
//        $defaultOptions = [
//            'item' => function($index, $label, $name, $checked, $value) {
//                return Html::radio($name,$checked,['value'=>$value,'id'=>$name.$index]) . Html::label($label,$name.$index);
//                return $return;
//            },
//            'class'=>'input-list-wrapper'
//        ];
//        $options = array_merge($defaultOptions, $options);
//
//        return parent::radioList($items,$options);
//    }
}
