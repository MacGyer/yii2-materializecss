<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * StaticChip renders small units of information.
 *
 * An usual use case is the displaying of contact information.
 * If you need tagging support in forms or inputs generally, please use [[\macgyer\yii2materializecss\widgets\form\ChipInput|ChipInput]].
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 *
 * @see https://materializecss.com/chips.html
 * @package widgets
 */
class StaticChip extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options;

    /**
     * @var string the content of the chip besides the optional image and/or [[Icon|Icon]].
     */
    public $content;

    /**
     * @var boolean whether to encode the content.
     *
     * If this property is set to "false" the content will be rendered without the encoding of HTML special characters.
     */
    public $encodeContent = true;

    /**
     * @var array the HTML attributes for the img tag.
     *
     * Specifiy at least the `src` key representing the source of the image.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $imageOptions;

    /**
     * @var array the options for the optional [[Icon|Icon]].
     *
     * If there is an icon present in the chip element, Materialize will
     * treat it as a close (i. e. remove) trigger.
     *
     * To specify an [[Icon|Icon]] you can use the following parameters:
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // optional, defaults to 'close'
     *     'position' => 'position of the icon',            // optional, 'left' or 'right', defaults to 'left'
     *     'options' => 'the HTML attributes for the icon', // optional
     * ]
     * ```
     *
     * @see Icon|Icon
     */
    public $icon;

    /**
     * @var boolean whether to render the [[Icon|Icon]] inside the chip.
     */
    public $renderIcon = false;

    /**
     * Initializes the widget.
     *
     * @throws InvalidConfigException if the src property ot the image is not defined
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'chip']);

        if ($this->imageOptions && !isset($this->imageOptions['src'])) {
            throw new InvalidConfigException('The "src" attribute for the image is required.');
        }

        if ($this->renderIcon && !isset($this->icon['name'])) {
            $this->icon['name'] = 'close';
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @throws \Exception
     * @uses [[Icon]]
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->options);

        if ($this->imageOptions) {
            $src = ArrayHelper::remove($this->imageOptions, 'src', '');
            $html[] = Html::img($src, $this->imageOptions);
        }

        $html[] = $this->encodeContent ? Html::encode($this->content) : $this->content;

        if ($this->renderIcon) {
            Html::addCssClass($this->icon['options'], ['close-trigger' => 'close']);

            $html[] = Icon::widget([
                'name' => ArrayHelper::getValue($this->icon, 'name', null),
                'position' => ArrayHelper::getValue($this->icon, 'position', ''),
                'options' => ArrayHelper::getValue($this->icon, 'options', [])
            ]);
        }

        $html[] = Html::endTag($tag);
        return implode("\n", $html);
    }
}
