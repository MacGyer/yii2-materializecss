<?php

namespace common\widgets;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

class Select extends BaseInputWidget
{
    public $items = [];

    public $options = [];

    public function init()
    {
        parent::init();

        $placeholder = ArrayHelper::remove($this->options, 'placeholder', 'Please choose');

        if ($placeholder !== false) {
            $this->items = ArrayHelper::merge(['' => $placeholder], $this->items);

            $this->options['options'] = [
                '' => ['disabled' => true, 'selected' => true],
            ];
        }

        $this->registerPlugin('material_select');
    }

    public function run()
    {
        if ($this->hasModel()) {
            $html = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            $html = Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }

        return $html;
    }
}
