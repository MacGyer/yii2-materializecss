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
 * To be compatible with GDPR (EU) the MaterializeFontAsset is not loaded automatically via the [[\macgyer\yii2materializecss\assets\MaterializeAsset|MaterializeAsset]]. The font asset requests the Material Icon font from Google servers (as stated in the Materialize docs).
 * If you are not affected by GDPR, simply load the [[\macgyer\yii2materializecss\assets\MaterializeFontAsset|MaterializeFontAsset]] in your layout or AppAsset.
 *
 * Otherwise you need to self-host the Material Icon font (i. e. do not request them from Google). You could use `material-icons` (https://www.npmjs.com/package/material-icons) to load the font files, CSS and SCSS from NPM and include them in your build process.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @see https://materializecss.com/icons.html
 */
class Icon extends BaseWidget
{
    /**
     * Sets the [[size]] of the icon to "tiny".
     */
    public const SIZE_TINY = 'tiny';
    /**
     * Sets the [[size]] of the icon to "small". This is the default.
     */
    public const SIZE_SMALL = 'small';
    /**
     * Sets the [[size]] of the icon to "medium".
     */
    public const SIZE_MEDIUM = 'medium';
    /**
     * Sets the [[size]] of the icon to "large".
     */
    public const SIZE_LARGE = 'large';
    /**
     * Sets the [[position]] of the icon to "left".
     */
    public const POSITION_LEFT = 'left';
    /**
     * Sets the [[position]] of the icon to "right".
     */
    public const POSITION_RIGHT = 'right';

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
     */
    public $position;

    /**
     * @var string the size of the icon.
     *
     * The default icon size is "small".
     */
    public $size = self::SIZE_SMALL;

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
        Html::addCssClass($this->options, ['widget' => 'material-icons']);

        if ($this->position) {
            Html::addCssClass($this->options, ['material-icon-position' => $this->position]);
        }

        if ($this->size) {
            Html::addCssClass($this->options, ['material-icon-size' => $this->size]);
        }
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
