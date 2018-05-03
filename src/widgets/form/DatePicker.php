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
 * DatePicker renders an date picker input element.
 *
 * Materialize is using a modified version of the JS library pickadate.js.
 *
 * @see https://materializecss.com/pickers.html#date-picker
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class DatePicker extends BaseInputWidget
{
    /**
     * @var array the options for the underlying datepicker JS plugin.
     *
     * @see https://materializecss.com/pickers.html#date-picker
     */
    public $clientOptions = [];

    /**
     * @var array the event handlers for the underlying date picker JS plugin.
     *
     * @see https://materializecss.com/pickers.html#date-picker
     */
    public $clientEvents = [];

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $this->registerPlugin('Datepicker', '.datepicker');

        Html::addCssClass($this->options, 'datepicker');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('text', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('text', $this->name, $this->value, $this->options);
        }
    }
}
