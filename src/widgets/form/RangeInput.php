<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\assets\NoUiSliderAsset;
use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * RangeInput renders a slider input element. You can specify to use a simple HTML5 range `<input>` or make use of the versatile
 * noUiSlider JS plugin.
 *
 * All noUiSlider settings provided as member variables are needed for out-of-the-box functionality. See the noUiSlider
 * docs for more options and events.
 *
 * <strong>Please note:</strong> This widget provides functionality for sliders with one handle only. If you want to use
 * noUiSlider with multiple handles or more complex functionality you need to create your own class and inherit from this class.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 *
 * @see https://materializecss.com/range.html
 * @see https://refreshless.com/nouislider/
 */
class RangeInput extends BaseInputWidget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the slider element. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the slider element's tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $sliderOptions = [];

    /**
     * @var boolean whether to use noUiSlider.
     * @see http://materializecss.com/forms.html#range
     */
    public $useNoUiSlider = true;

    /**
     * @var boolean whether to render an hidden input field to hold the slider value.
     * This options only takes effect, when [[useNoUiSlider]] has been set to `true`.
     */
    public $renderHiddenInput = true;

    /**
     * @var array the HTML attributes for the actual input element.
     *
     * If you have set [[useNoUiSlider]] and [[renderHiddenInput]] both to `true`, the input element will be used as a hidden
     * input field holding the value issued by the slider and these options applied.
     *
     * When setting [[useNoUiSlider]] to `false`, the input options will be applied to the `<input type="range">` element.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $inputOptions = [];

    /**
     * @var integer the start value of the slider.
     * This options only takes effect, when [[useNoUiSlider]] has been set to `true`.
     * @see https://refreshless.com/nouislider/slider-options/#section-start
     */
    public $start = 0;

    /**
     * @var array the min and max values of the slider.
     * This options only takes effect, when [[useNoUiSlider]] has been set to `true`.
     */
    public $range = [
        'min' => 0,
        'max' => 100
    ];
    /**
     * @var integer the stepping value when moving the slider handle.
     * This options only takes effect, when [[useNoUiSlider]] has been set to `true`.
     * @see https://refreshless.com/nouislider/slider-options/#section-step
     */
    public $step = 1;

    /**
     * @var boolean whether to use a vertical slider.
     * This options only takes effect, when [[useNoUiSlider]] has been set to `true`.
     * @see https://refreshless.com/nouislider/slider-options/#section-orientation
     */
    public $vertical = false;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();
        if ($this->useNoUiSlider) {
            if (!ArrayHelper::keyExists('start', $this->clientOptions)) {
                $this->clientOptions['start'] = $this->start;
            }

            if (!ArrayHelper::keyExists('range', $this->clientOptions)) {
                $this->clientOptions['range'] = $this->range;
            }

            if (!ArrayHelper::keyExists('step', $this->clientOptions)) {
                $this->clientOptions['step'] = $this->step;
            }

            if ($this->vertical) {
                $this->clientOptions['orientation'] = 'vertical';
            }

            if (!isset($this->sliderOptions['id'])) {
                $this->sliderOptions['id'] = $this->getId();
            }

            $this->addUpdateEvent();
            $this->registerClientScripts();
        }
    }

    /**
     * Adds default noUiSlider update event to [[clientEvents]].
     * @see https://refreshless.com/nouislider/events-callbacks/#section-update
     */
    protected function addUpdateEvent()
    {
        $sliderId = $this->sliderOptions['id'];
        $this->inputOptions['data-slider-target'] = $sliderId;

        if (!isset($this->clientEvents['update'])) {
            $this->clientEvents['update'] = new JsExpression(<<<JS
function (values, handle) {
    var value = values[handle];
    $('[data-slider-target="{$sliderId}"]').val(value);
}
JS
            );
        }
    }

    /**
     * Execute the widget.
     *
     * @return string the rendered markup.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->options);

        if (!$this->useNoUiSlider) {
            $html[] = $this->renderHtml5RangeInput();
        } else {
            $html[] = $this->renderNoUiSlider();
        }

        $html[] = Html::endTag($tag);
        return implode("\n", $html);
    }

    /**
     * Renders a standard HTML5 range input field.
     * This is only being effective when [[$useNoUiSlider]] is set to 'false'.
     *
     * @return string the field markup.
     */
    protected function renderHtml5RangeInput()
    {
        $html[] = Html::beginTag('div', ['class' => 'range-field']);

        // workaround for: https://github.com/Dogfalo/materialize/issues/5761
        if (!isset($this->inputOptions['min'])) {
            $this->inputOptions['min'] = 0;
        }
        if (!isset($this->inputOptions['max'])) {
            $this->inputOptions['max'] = 100;
        }

        if ($this->hasModel()) {
            $html[] = Html::activeInput('range', $this->model, $this->attribute, $this->inputOptions);
        } else {
            $html[] = Html::input('range', $this->name, $this->value, $this->inputOptions);
        }

        $html[] = Html::endTag('div');

        return implode("\n", $html);
    }

    /**
     * Renders the markup for the noUiSlider plugin.
     * This is only being effective when [[$useNoUiSlider]] is set to 'true'.
     *
     * @return string the field markup.
     */
    protected function renderNoUiSlider()
    {
        $html[] = Html::tag('div', '', $this->sliderOptions);
        if ($this->renderHiddenInput) {
            $html[] = $this->renderHiddenInput();
        }

        return implode("\n", $html);
    }

    /**
     * Renders a hidden input field which holds the value issued by the slider.
     * This is only being effective when [[$useNoUiSlider]] is set to 'true'.
     *
     * @return string the input field markup.
     */
    protected function renderHiddenInput()
    {
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute, $this->inputOptions);
        } else {
            return Html::hiddenInput($this->name, $this->value, $this->inputOptions);
        }
    }

    /**
     * Registers all scripts needed by the underlying JS plugin.
     */
    protected function registerClientScripts()
    {
        $view = $this->getView();
        NoUiSliderAsset::register($view);

        $id = $this->sliderOptions['id'];
        $varName = $this->getUniqueId('slider_');

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
            $view->registerJs(<<<JS
var $varName = document.getElementById('$id');
noUiSlider.create($varName, {$options});
JS
            );
        }

        $this->registerClientEvents($varName);
    }

    /**
     * Registers the events of the slider.
     *
     * @param string $sliderVarName the JS variable name of the slider element.
     */
    protected function registerClientEvents($sliderVarName = null)
    {
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$sliderVarName.noUiSlider.on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}
