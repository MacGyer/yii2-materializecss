<?php

namespace macgyer\yii2materializecss\lib;

use yii\base\Widget;

/**
 * BaseWidget is the base class for all non-input widgets in this extension.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 */
class BaseWidget extends Widget
{
    use MaterializeWidgetTrait;

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
}
