<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class SwitchButton
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
     * If not set, it will take the default value '1'.
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
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options;

    /**
     * @var string the text displaying the unchecked status.
     */
    public $offText = 'Off';

    /**
     * @var string the text displaying the checked status.
     */
    public $onText = 'On';

    /**
     * @var array the HTML attributes for the underlying input tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $inputOptions = [];

    /**
     * @var bool the control for setting the "checked" attribute in the input tag.
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

        $this->inputOptions['uncheck'] = isset($this->uncheck) ? $this->uncheck : '0';
        $this->inputOptions['value'] = isset($this->value) ? $this->value : '1';
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
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
     * @return string
     */
    private function renderSwitch()
    {
        $value = ArrayHelper::getValue($this->inputOptions, 'value', null);

        if ($this->hasModel()) {
            $attributeValue = Html::getAttributeValue($this->model, $this->attribute);
            $this->checked = "{$value}" === "{$attributeValue}";
        }

        $name = ArrayHelper::remove($this->inputOptions, 'name', null);

        return implode("\n", [
            Html::beginTag('label'),
            Html::encode($this->offText),
            Html::checkbox($name, $this->checked, $this->inputOptions),
            Html::tag('span', '', ['class' => 'lever']),
            Html::encode($this->onText),
            Html::endTag('label'),
        ]);
    }
}
