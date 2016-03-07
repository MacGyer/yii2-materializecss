<?php

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * Class DatePicker
 * @package macgyer\yii2materializecss\widgets\form
 */
class DatePicker extends BaseInputWidget
{
    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $this->registerPlugin('pickadate');

        Html::addCssClass($this->options, 'datepicker');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('date', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('date', $this->name, $this->value, $this->options);
        }
    }
}
