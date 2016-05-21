<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\grid;

/**
 * Class GridView
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage grid
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @var array the HTML attributes for the grid table element.
     * @see http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail for details on 
     * how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table striped bordered'];
}
