<?php

namespace common\widgets;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

class Select extends BaseInputWidget
{
    public $items = [];

    public function init()
    {
        parent::init();

        $this->registerPlugin('material_select');
    }

    public function run()
    {
        if ($this->hasModel()) {
            $html = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            $html = Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
    }
}
