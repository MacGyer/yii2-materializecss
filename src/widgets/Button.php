<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

/**
 * Button renders an HTML button.
 *
 * There are three main button types described in Materialize.
 * - the raised button is a standard button that signifies actions and seek to give depth to a mostly flat page
 * - the floating circular action button is meant for very important functions
 * - flat buttons are usually used within elements that already have depth like cards or modals
 *
 * The button can be displayed with an optional icon. This class uses the [[Icon|Icon]] widget to show icons.
 *
 * @see https://materializecss.com/buttons.html
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 */
class Button extends BaseWidget
{
    /**
     * Sets the [[type]] of the button to "raised". This is the default.
     */
    const TYPE_RAISED = 'raised';

    /**
     * Sets the [[type]] of the button to "floating".
     */
    const TYPE_FLOATING = 'floating';

    /**
     * Sets the [[type]] of the button to "flat".
     */
    const TYPE_FLAT = 'flat';

    /**
     * Sets the [[size]] of the button to the default size.
     */
    const SIZE_DEFAULT = 'default';

    /**
     * Sets the [[size]] of the button to "small".
     */
    const SIZE_SMALL = 'small';

    /**
     * Sets the [[size]] of the button to "large".
     */
    const SIZE_LARGE = 'large';

    /**
     * @var string the tag used to render the button.
     */
    public $tagName = 'button';

    /**
     * @var string the label on the button. If you do not want a label text to be rendered, set this options to "false".
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
     * @var string the type of button to be rendered.
     *
     * The following options are supported:
     * - raised
     * - floating
     * - flat
     *
     * This property defaults to "raised". To set the type, use the corresponding `TYPE_*` constant of this class.
     * If no type from this range is given, the button will be of the "raised" type.
     */
    public $type = self::TYPE_RAISED;

    /**
     * @var string the size of button to be rendered.
     *
     * The following options are supported:
     * - default
     * - small
     * - large
     *
     * This property defaults to "default". To set the type, use the corresponding `TYPE_*` constant of this class.
     * If no type from this range is given, the button will be of the "default" type.
     */
    public $size = self::SIZE_DEFAULT;

    /**
     * @var boolean whether the button shall be disabled.
     */
    public $disabled = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, ['widget' => 'btn']);

        switch ($this->type) {
            case self::TYPE_FLOATING:
            case self::TYPE_FLAT:
                Html::addCssClass($this->options, ['btn_type' => "btn-$this->type"]);
                break;
        }

        switch ($this->size) {
            case self::SIZE_SMALL:
            case self::SIZE_LARGE:
                Html::addCssClass($this->options, ['btn_size' => "btn-$this->size"]);
                break;
        }

//        if ($this->large) {
//            Html::addCssClass($this->options, ['btn_size' => 'btn-large']);
//        }

        if ($this->disabled) {
            Html::addCssClass($this->options, ['btn_disabled' => 'disabled']);
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @uses [[renderIcon]]
     */
    public function run()
    {
        if ($this->label !== false) {
            $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;
        } else {
            $label = '';
        }

        $content = $this->renderIcon() . $label;

        return $this->tagName === 'button' ? Html::button($content, $this->options) : Html::tag($this->tagName, $content, $this->options);
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
