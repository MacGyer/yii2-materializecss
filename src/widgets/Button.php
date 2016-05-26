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
 * Button renders a HTML button.
 *
 * There are three main button types described in Materialize.
 * - the raised button is a standard button that signifies actions and seek to give depth to a mostly flat page
 * - the floating circular action button is meant for very important functions
 * - flat buttons are usually used within elements that already have depth like cards or modals
 *
 * The button can be displayed with an optional icon. This class uses the [[Icon|Icon]] widget to show icons.
 *
 * @see http://materializecss.com/buttons.html
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 */
class Button extends BaseWidget
{
    /**
     * @var string the tag used to render the button.
     */
    public $tagName = 'button';

    /**
     * @var string the label on the button.
     */
    public $label = 'Button';

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;

    /**
     * @var array the options for the optional icon.
     *
     * To specify an icon you can use the following parameters:
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // required
     *     'position' => 'position of the icon',            // optional, 'left' or 'right', defaults to 'left'
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     *
     * @see Icon|Icon
     */
    public $icon = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, ['widget' => 'btn']);
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @uses [[renderIcon]]
     */
    public function run()
    {
        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        $content = $this->renderIcon() . $label;

        return Html::tag($this->tagName, $content, $this->options);
    }

    /**
     * Renders an icon.
     *
     * @return string the rendered icon
     * @throws \yii\base\InvalidConfigException if icon name is not specified
     *
     * @uses http://www.yiiframework.com/doc-2.0/yii-helpers-basearrayhelper.html#getValue()-detail
     * @see Icon::run
     */
    protected function renderIcon()
    {
        if (!$this->icon) {
            return '';
        }

        return Icon::widget([
            'name' => ArrayHelper::getValue($this->icon, 'name', null),
            'position' => ArrayHelper::getValue($this->icon, 'position', null),
            'options' => ArrayHelper::getValue($this->icon, 'options', [])
        ]);
    }
}
