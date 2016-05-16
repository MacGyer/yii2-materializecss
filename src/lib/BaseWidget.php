<?php

namespace macgyer\yii2materializecss\lib;

use yii\base\Widget;

/**
 * Class BaseWidget
 * @package macgyer\yii2materializecss\lib
 */
class BaseWidget extends Widget
{
    use MaterializeWidgetTrait;

    public $options = [];
}
