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
 * Progress renders a linear progress bar.
 *
 * Use this widget to give the user feedback about the loading of content or if you have actions that require multiple
 * steps to complete.
 *
 * There are two types of progress bars available:
 * - inderterminated with an animated recurring bar
 * - determinated with a defined length
 *
 * For an indeterminated progress bar simply add the following
 *
 * ```php
 * <?= Progress::widget() ?>
 * ```
 *
 * To render an determinated progress bar with an initial value set [[value]] to the desired value and
 * change [[type]] to "determinate"
 *
 * ```php
 * <?= Progress::widget([
 *      'type' => 'determinate',
 *      'value' => 10
 * ]) ?>
 * ```
 *
 * @see Spinner|Spinner
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @since 1.0.2
 * @package widgets
 */
class Progress extends BaseWidget
{
    /**
     * Sets the [[type]] of the progress bar to 'determinate'.
     */
    const TYPE_DETERMINATE = 'determinate';

    /**
     * Sets the [[type]] of the progress bar to 'indeterminate'. This is the default.
     */
    const TYPE_INDETERMINATE = 'indeterminate';

    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the progress tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $progressOptions = [];

    /**
     * @var string the type of the progress bar.
     *
     * The following options are supported:
     *
     * - indeterminate (default)
     * - determinate
     *
     * @see https://materializecss.com/preloader.html
     */
    public $type = self::TYPE_INDETERMINATE;

    /**
     * @var integer the (initial) value for 'determinate' progress bars.
     *
     * The supported range is [0 ... 100].
     * This value will be applied as inline CSS style to show the progress:
     *
     * ```
     * <div class="determinate" style="width: 70%"></div>
     * ```
     *
     * @see https://materializecss.com/preloader.html
     */
    public $value = 0;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'progress']);
        Html::addCssClass($this->progressOptions, ['type' => $this->type]);

        if ($this->type === self::TYPE_DETERMINATE) {
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
