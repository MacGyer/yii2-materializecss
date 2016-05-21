<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * Class Progress
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @since 1.0.2
 */
class Progress extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the progress tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $progressOptions = [];

    /**
     * @var string the type of the progress bar
     *
     * The following options are supported:
     *
     * - indeterminate (default)
     * - determinate
     *
     * @see http://materializecss.com/preloader.html
     */
    public $type = 'indeterminate';

    /**
     * @var int the (initial) value for 'determinate' progress bars
     *
     * The supported range is [0 ... 100].
     * This value will be applied as inline CSS style to show the progress:
     *
     * <div class="determinate" style="width: 70%"></div>
     *
     * @see http://materializecss.com/preloader.html
     */
    public $value = 0;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'progress']);
        Html::addCssClass($this->progressOptions, ['type' => $this->type]);

        if ($this->type === 'determinate') {
            Html::addCssStyle($this->progressOptions, ['width' => $this->value . '%']);
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $html[] = Html::beginTag('div', $this->options);
        $html[] = Html::tag('div', null, $this->progressOptions);
        $html[] = Html::endTag('div');

        return implode("\n", $html);
    }
}
