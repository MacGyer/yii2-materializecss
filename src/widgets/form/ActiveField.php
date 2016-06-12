<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Icon;
use yii\helpers\ArrayHelper;

// TODO: switch input --> own widget
// TODO: range with noUiSlider --> own widget
// TODO: checkbox / checkbox list
// TODO: radio / radio list
// TODO: select ?
// TODO: Datepicker --> own widget
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
     * Initializes the widget.
     */
    public function init()
    {
        if ($this->form->enableClientScript === true && $this->form->enableClientValidation === true) {
            Html::addCssClass($this->inputOptions, ['inputValidation' => 'validate']);
        }
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
     * @return ActiveField
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
     * Renders a color input.
     * @param array $options
     * @return ActiveField
     */
    public function colorInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'color']);
        return parent::input('color', $options);
    }
    
    /**
     * Renders a date input.
     * @param array $options
     * @return ActiveField
     */
    public function dateInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'date']);
        return parent::input('date', $options);
    }
    
    /**
     * Renders a datetime input.
     * @param array $options
     * @return ActiveField
     */
    public function datetimeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'datetime']);
        return parent::input('datetime', $options);
    }
    
    /**
     * Renders a datetime local input.
     * @param array $options
     * @return ActiveField
     */
    public function datetimeLocalInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'datetime-local']);
        return parent::input('datetime-local', $options);
    }
    
    /**
     * Renders an email input.
     * @param array $options
     * @return ActiveField
     */
    public function emailInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'email']);
        $options = ArrayHelper::merge($this->inputOptions, $options);

        return parent::input('email', $options);
    }

    /**
     * Renders a month input.
     * @param array $options
     * @return ActiveField
     */
    public function monthInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'month']);
        return parent::input('month', $options);
    }

    /**
     * Renders a number input.
     * @param array $options
     * @return ActiveField
     */
    public function numberInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'number']);
        return parent::input('number', $options);
    }

    /**
     * Renders a range input.
     * @param array $options
     * @return ActiveField
     */
    public function rangeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'email']);
        return parent::input('email', $options);
    }

    /**
     * Renders a search input.
     * @param array $options
     * @return ActiveField
     */
    public function searchInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'search']);
        return parent::input('search', $options);
    }

    /**
     * Renders a phone input.
     * @param array $options
     * @return ActiveField
     */
    public function telInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'tel']);
        return parent::input('tel', $options);
    }

    /**
     * Renders a time input.
     * @param array $options
     * @return ActiveField
     */
    public function timeInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'time']);
        return parent::input('time', $options);
    }

    /**
     * Renders an URL input.
     * @param array $options
     * @return ActiveField
     */
    public function urlInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'url']);
        return parent::input('url', $options);
    }

    /**
     * Renders a week input.
     * @param array $options
     * @return ActiveField
     */
    public function weekInput($options = [])
    {
        Html::addCssClass($options, ['input' => 'week']);
        return parent::input('week', $options);
    }

    /**
     * Renders a textarea.
     * @param array $options
     * @return ActiveField
     */
    public function textarea($options = [])
    {
        Html::addCssClass($options, ['textarea' => 'materialize-textarea']);
        return parent::textarea($options);
    }
}
