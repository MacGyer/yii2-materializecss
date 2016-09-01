<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\assets\TimePickerAsset;
use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * TimePicker renders a time picker input element.
 *
 * This widget implements Ching Yaw Hao's clock picker solution for Materialize.
 *
 * @see https://github.com/chingyawhao/materialize-clockpicker
 * @author Ching Yaw Hao
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class TimePicker extends BaseInputWidget
{
    /**
     * @var array the options for the underlying datepicker JS plugin.
     * Please refer to the corresponding [documentation on Github](https://github.com/chingyawhao/materialize-clockpicker#options).
     *
     * @see https://github.com/chingyawhao/materialize-clockpicker#options
     */
    public $clientOptions = [];

    /**
     * @var array the event handlers for the underlying date picker JS plugin.
     * Please refer to the corresponding [documentation on Github](https://github.com/chingyawhao/materialize-clockpicker#options).
     *
     * @see https://github.com/chingyawhao/materialize-clockpicker#options
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->clientOptions['donetext'])) {
            $this->clientOptions['donetext'] = 'Select';
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $this->registerAssets();

        Html::addCssClass($this->options, 'clockpicker');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('time', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('time', $this->name, $this->value, $this->options);
        }
    }

    /**
     * Registers the asset bundle and initializes plugin call.
     */
    private function registerAssets()
    {
        $view = $this->getView();
        TimePickerAsset::register($view);

        $this->registerPlugin('pickatime');
    }
}
