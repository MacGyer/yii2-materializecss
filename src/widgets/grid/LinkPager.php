<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\grid;

/**
 * LinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage data
 * @see [\yii\widgets\LinkPager](http://www.yiiframework.com/doc-2.0/yii-widgets-linkpager.html)
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @var string|bool the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '<i class="material-icons">chevron_right</i>';

    /**
     * @var string|bool the label for the "previous" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '<i class="material-icons">chevron_left</i>';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
    }
}
