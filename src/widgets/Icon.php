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
 * Icon can be used to display a Materialize icon.
 *
 * Please note that the Materialize icons are shipped in a separate font file. This font file is automatically registered
 * by the [[\macgyer\yii2materializecss\assets\MaterializeAsset|MaterializeAsset]].
 *
 * If you do not load the default [[\macgyer\yii2materializecss\assets\MaterializeAsset|MaterializeAsset]] make sure to at least load
 * [[\macgyer\yii2materializecss\assets\MaterializeFontAsset|MaterializeFontAsset]] (or another source providing the font file) to correctly
 * display the icons.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @see https://materializecss.com/icons.html
 */
class Icon extends BaseWidget
{
    /**
     * @var string the name of the icon.
     *
     * @see https://materializecss.com/icons.html
     */
    public $name;

    /**
     * @var string the position of the icon.
     *
     * Currently "left" and "right" are natively supported by Materialize, but you can set this property to a custom string
     * which will be added to the HTML class attribute and thus can be individually styled.
     *
     * The default icon position is "left".
     */
    public $position;

    /**
     * @var array the HTML options for the icon tag.
     *
     * The following special options are recognized:
     *
     * - tag: string, defaults to "i"
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * Initializes the widget.
     *
     * @throws InvalidConfigException if icon name is not specified
     */
    public function init()
    {
        parent::init();

        if (!$this->name) {
            throw new InvalidConfigException('The icon name must be specified.');
        }

        if ($this->position === null) {
            $this->position = 'left';
        }

        Html::addCssClass($this->options, ['material-icons', $this->position]);
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'i');
        return Html::tag($tag, $this->name, $this->options);
    }
}
