<?php

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * Class TimePicker
 * @package macgyer\yii2materializecss\widgets\form
 *
 * @author Leonardo J. Caballero G. <leonardocaballero@gmail.com>
 */
class TimePicker extends BaseInputWidget
{
    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $this->registerPlugin('pickatime');

        Html::addCssClass($this->options, 'timepicker');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('time', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('time', $this->name, $this->value, $this->options);
        }
    }
}
