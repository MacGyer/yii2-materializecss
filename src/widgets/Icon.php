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

/**
 * Class Icon
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 */
class Icon extends BaseWidget
{
    /**
     * @var string the name of the icon
     *
     * @see http://materializecss.com/icons.html
     */
    public $name;

    /**
     * @var string the position of the icon
     *
     * defaults to "left"
     *
     * currently "left" and "right" are natively supported by materializecss
     * you can set it to a custom string which will be added to the HTML class attribute
     */
    public $position;

    /**
     * @var array the HTML options for the "img" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * Initialize the widget.
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
        return Html::tag('i', $this->name, $this->options);
    }
}
