<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Icon;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * SwitchButton renders a toggle button.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class SwitchButton extends BaseInputWidget
{
    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;

    /**
     * @var string the input value.
     *
     * If not set, it will take the default value "1".
     */
    public $value;

    /**
     * @var string the value associated with the uncheck state of the radio button.
     *
     * If not set, it will take the default value '0'. This method will render a hidden input
     * so that if the radio button is not checked and is submitted, the value of this attribute
     * will still be submitted to the server via the hidden input. If you do not want any
     * hidden input, you should explicitly set this option as null.
     */
    public $uncheck;

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options;

    /**
     * @var string the text displaying the unchecked status. This can be used in conjunction with the [[offIcon]].
     */
    public $offText = 'Off';

    /**
     * @var boolean whether the off text should be HTML-encoded.
     */
    public $encodeOffText = true;

    /**
     * @var array the options for the optional off icon.
     *
     * To specify an icon you can use the following parameters:
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // required
     *     'position' => 'position of the icon',            // optional, 'left' or 'right', defaults to 'left'
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     *
     * @see Icon|Icon
     */
    public $offIcon = [];

    /**
     * @var string the text displaying the checked status. This can be used in conjunction with the [[onIcon]].
     */
    public $onText = 'On';

    /**
     * @var boolean whether the on text should be HTML-encoded.
     */
    public $encodeOnText = true;

    /**
     * @var array the options for the optional on icon.
     *
     * To specify an icon you can use the following parameters:
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // required
     *     'position' => 'position of the icon',            // optional, 'left' or 'right', defaults to 'left'
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     *
     * @see Icon|Icon
     */
    public $onIcon = [];

    /**
     * @var array the HTML attributes for the underlying input tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $inputOptions = [];

    /**
     * @var boolean the control for setting the "checked" attribute in the input tag.
     */
    public $checked = false;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['container' => 'switch']);

        if ($this->hasModel()) {
            if (!isset($this->inputOptions['name'])) {
                $this->inputOptions['name'] = Html::getInputName($this->model, $this->attribute);
            }

            if (!isset($this->inputOptions['id'])) {
                $this->inputOptions['id'] = Html::getInputId($this->model, $this->attribute);
            }
        } else {
            $this->inputOptions['name'] = $this->name;
        }

        $this->inputOptions['uncheck'] = isset($this->uncheck) ? $this->uncheck : is_null($this->uncheck) ? null : '0';
        $this->inputOptions['value'] = isset($this->value) ? $this->value : '1';
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @uses [[renderSwitch()]]
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html = Html::beginTag($tag, $this->options);

        $html .= $this->renderSwitch();

        $html .= Html::endTag($tag);

        return $html;
    }

    /**
     * Render the switch button checkbox.
     * @return string
     * @uses [yii\helper\BaseHtml::checkbox()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#checkbox()-detail)
     */
    protected function renderSwitch()
    {
        $value = ArrayHelper::getValue($this->inputOptions, 'value', null);

        if ($this->hasModel()) {
            $attributeValue = Html::getAttributeValue($this->model, $this->attribute);
            $this->checked = "{$value}" === "{$attributeValue}";
        }

        $name = ArrayHelper::remove($this->inputOptions, 'name', null);

        return implode("\n", [
            Html::beginTag('label'),
            $this->renderLabel('off'),
            Html::checkbox($name, $this->checked, $this->inputOptions),
            Html::tag('span', '', ['class' => 'lever']),
            $this->renderLabel('on'),
            Html::endTag('label'),
        ]);
    }

    /**
     * Renders the HTML markup for the on/off label.
     *
     * This method also renders the corresponding icons, if set.
     *
     * @param string $state the state to used. Use "off" or "on".
     * @return string the rendered label.
     * @uses [[Icon|Icon]]
     */
    protected function renderLabel($state)
    {
        $icon = $this->renderIcon($state);
        $encodeProperty = "encode" . ucfirst($state) . "Text";
        $textProperty = "{$state}Text";

        $label = $this->$encodeProperty ? Html::encode($this->$textProperty) : $this->$textProperty;
        $label .= $icon;

        $html = [];
        $html[] = Html::beginTag('span', ['class' => "{$state}Label"]);
        $html[] = $label;
        $html[] = Html::endTag('span');

        return implode("\n", $html);
    }

    /**
     * Renders an icon.
     *
     * @param string $state the name of the icon property.
     * @return string the rendered icon
     *
     * @uses http://www.yiiframework.com/doc-2.0/yii-helpers-basearrayhelper.html#getValue()-detail
     * @see Icon::run
     */
    protected function renderIcon($state)
    {
        $iconProperty = "{$state}Icon";

        if (!$this->$iconProperty) {
            return '';
        }

        return Icon::widget([
            'name' => ArrayHelper::getValue($this->$iconProperty, 'name', null),
            'position' => ArrayHelper::getValue($this->$iconProperty, 'position', null),
            'options' => ArrayHelper::getValue($this->$iconProperty, 'options', [])
        ]);
    }
}
