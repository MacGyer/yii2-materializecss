<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\data;

/**
 * Class DetailView
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage data
 */
class DetailView extends \yii\widgets\DetailView
{
    /**
     * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
     * what container tag should be used. It defaults to "table" if not set.
     * @see http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail for details on 
     * how attributes are being rendered.
     */
    public $options = ['class' => 'table striped bordered detail-view'];
}
