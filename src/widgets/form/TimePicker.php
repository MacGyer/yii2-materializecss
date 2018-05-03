<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * TimePicker renders a time picker input element with a modified version of pickadate.js.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 * @see https://materializecss.com/pickers.html#time-picker
 */
class TimePicker extends BaseInputWidget
{
    /**
     * @var array the options for the underlying datepicker JS plugin.
     *
     * @see https://materializecss.com/pickers.html#time-picker
     */
    public $clientOptions = [];

    /**
     * @var array the event handlers for the underlying date picker JS plugin.
     *
     * @see https://materializecss.com/pickers.html#time-picker
     */
    public $clientEvents = [];

    /**
     * Execute the widget.
     * @return string the result of widget execution to be outputted
     */
    public function run()
    {
        $this->registerPlugin('Timepicker', '.timepicker');

        Html::addCssClass($this->options, 'timepicker');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('text', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('text', $this->name, $this->value, $this->options);
        }
    }
}
