<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\lib;

use yii\base\Widget;

/**
 * BaseWidget is the base class for all non-input widgets in this extension.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package lib
 */
class BaseWidget extends Widget
{
    use MaterializeWidgetTrait;

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) 
     * for details on how attributes are being rendered.
     */
    public $options = [];
}
