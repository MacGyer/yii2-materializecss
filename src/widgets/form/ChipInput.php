<?php

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ChipInput extends BaseInputWidget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var boolean whether to render an hidden input field to hold the chips data.
     * If you need an input field which is associated with your model class and to which you can assign the actual chips
     * data via JS, set this option to 'true'.
     */
    public $renderHiddenInput = false;

    /**
     * @var array the HTML attributes for the actual input element.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $inputOptions = [];

    public $items = [];
    public $placeholder;
    public $secondaryPlaceholder;
    public $autocompleteOptions = [];

    public function init()
    {
        parent::init();

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }
        Html::addCssClass($this->containerOptions, ['widget-container' => 'chips-container']);

        if ($this->items) {
            $this->clientOptions['data'] = $this->items;
        }
        if ($this->autocompleteOptions) {
            $this->clientOptions['autocompleteOptions'] = $this->autocompleteOptions;
        }
        if ($this->placeholder) {
            $this->clientOptions['placeholder'] = $this->placeholder;
        }
        if ($this->secondaryPlaceholder) {
            $this->clientOptions['secondaryPlaceholder'] = $this->secondaryPlaceholder;
        }

        $this->registerPlugin('Chips', "#{$this->containerOptions['id']} .chips");
    }

    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->containerOptions);
        if ($this->renderHiddenInput) {
            $html[] = $this->renderHiddenInput();
        }

        $html[] = Html::beginTag('div', ['class' => 'chips']);

        $html[] = Html::endTag('div');
        $html[] = Html::endTag($tag);
        return implode("\n", $html);
    }

    /**
     * Renders a hidden input field which can be used to assign the chips data to via JS.
     *
     * @return string the input field markup.
     */
    protected function renderHiddenInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::hiddenInput($this->name, $this->value, $this->options);
        }
    }
}
