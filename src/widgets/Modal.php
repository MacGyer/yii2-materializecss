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
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the
 * [\yii\base\Widget::begin()](http://www.yiiframework.com/doc-2.0/yii-base-widget.html#begin()-detail) and
 * [\yii\base\Widget::end()](http://www.yiiframework.com/doc-2.0/yii-base-widget.html#end()-detail) calls within the
 * modal window:
 *
 * ```php
 * Modal::begin([
 *     'closeButton' => [
 *          'label' => 'Close modal',
 *          'tag' => 'span'
 *      ],
 *     'toggleButton' => [
 *          'label' => 'Open modal'
 *      ],
 *      'modalType' => Modal::TYPE_BOTTOM_SHEET,
 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ```
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @see https://materializecss.com/modals.html
 */
class Modal extends BaseWidget
{
    /**
     * The location of the [[closeButton]]. The close button will be rendered right before the content, inside the
     * container ".modal-content".
     */
    const CLOSE_BUTTON_POSITION_BEFORE_CONTENT = 'beforeContent';

    /**
     * The location of the [[closeButton]]. The close button will be rendered right after the content, inside the
     * container ".modal-content".
     */
    const CLOSE_BUTTON_POSITION_AFTER_CONTENT = 'afterContent';

    /**
     * The location of the [[closeButton]]. The close button will be rendered right before the footer content, inside
     * the container ".modal-footer".
     */
    const CLOSE_BUTTON_POSITION_BEFORE_FOOTER = 'beforeFooter';

    /**
     * The location of the [[closeButton]]. The close button will be rendered right before the footer content, inside
     * the container ".modal-footer".
     */
    const CLOSE_BUTTON_POSITION_AFTER_FOOTER = 'afterFooter';

    /**
     * The location of the [[closeButton]]. The close button will be rendered directly before the container ".modal-content" opens.
     */
    const CLOSE_BUTTON_POSITION_PRECEDE_CONTENT_CONTAINER = 'precedeContainer';

    /**
     * The location of the [[closeButton]]. The close button will be rendered directly after the container ".modal-content" closes.
     */
    const CLOSE_BUTTON_POSITION_SUCCEED_CONTENT_CONTAINER = 'succeedContainer';

    /**
     * The type of the Modal.
     */
    const TYPE_LEAN = 'lean';

    /**
     * The type of the Modal.
     */
    const TYPE_FIXED_FOOTER = 'fixedFooter';

    /**
     * The type of the Modal.
     */
    const TYPE_BOTTOM_SHEET = 'bottomSheet';

    /**
     * @var array the HTML attributes for the widget container tag. These special options are recognized:
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string the different modal types.
     *
     * The following options are supported
     *
     * - lean (default)
     * - fixedFooter
     * - bottomSheet
     *
     * @see https://materializecss.com/modals.html
     */
    public $modalType = self::TYPE_LEAN;

    /**
     * @var array|false the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://materializecss.com/modals.html)
     * for the supported HTML attributes.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $closeButton = [];

    /**
     * @var string the position of the close button.
     *
     * The following options are supported:
     *
     * - `beforeContent`, right before the content, inside the container ".modal-content"
     * - `afterContent`, right after the content, inside the container ".modal-content"
     * - `beforeFooter`, right before the footer content, inside the container ".modal-footer"
     * - `afterFooter`, right before the footer content, inside the container ".modal-footer"
     * - `precedeContainer`, directly before the container ".modal-content" opens
     * - `succeedContainer`, directly after the container ".modal-content" closes
     *
     * Defaults to "beforeContent".
     */
    public $closeButtonPosition = self::CLOSE_BUTTON_POSITION_BEFORE_CONTENT;

    /**
     * @var array|false the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://materializecss.com/modals.html)
     * for the supported HTML attributes.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $toggleButton = [];

    /**
     * @var string the content of the footer.
     */
    public $footer;

    /**
     * @var array the optional HTML attributes for the footer container.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $footerOptions = [];

    /**
     * @var float the opacity of the Modal overlay. Valid values are 0 through 1.
     */
    public $overlayOpacity = 0.5;

    /**
     * @var int duration of the opening transition in ms.
     */
    public $inDuration = 250;

    /**
     * @var int duration of the closing transition in ms.
     */
    public $outDuration = 250;

    /**
     * @var boolean whether the page scrolling is disabled when the Modal is open.
     */
    public $preventScrolling = true;

    /**
     * @var boolean whether the Modal can be closed by keyboard or click.
     */
    public $dismissible = true;

    /**
     * @var string|mixed the starting top offset.
     */
    public $startingTopOffset = '4%';

    /**
     * @var string|mixed the ending top offset.
     */
    public $endingTopOffset = '10%';

    /**
     * Initializes the widget.
     * @uses [[renderCloseButton()]]
     * @uses [[registerPlugin()]]
     */
    public function init()
    {
        parent::init();

        $this->initDefaults();

        $options = $this->options;

        $html = $this->renderToggleButton();

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html .= Html::beginTag($tag, $options);

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_PRECEDE_CONTENT_CONTAINER) {
            $html .= $this->renderCloseButton();
        }

        $html .= Html::beginTag('div', ['class' => 'modal-content']);

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_BEFORE_CONTENT) {
            $html .= $this->renderCloseButton();
        }

        echo $html;

        $this->registerPlugin('Modal');
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @uses [[renderCloseButton()]]
     */
    public function run()
    {
        $options = $this->options;
        $html = '';

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_AFTER_CONTENT) {
            $html = $this->renderCloseButton();
        }

        $html .= Html::endTag('div');

        $html .= $this->renderFooter();

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_SUCCEED_CONTENT_CONTAINER) {
            $html .= $this->renderCloseButton();
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html .= Html::endTag($tag);

        echo $html;
    }

    /**
     * Renders the Modal's toggle button.
     * @see toggleButton
     * @return null|string the rendered result.
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');

            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }

            if ($tag === 'button' && !isset($toggleButton['data-target'])) {
                $toggleButton['data-target'] = $this->options['id'];
            }

            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @see closeButton
     * @return null|string the rendered result.
     */
    protected function renderCloseButton()
    {
        if (($closeButton = $this->closeButton) !== false) {
            $tag = ArrayHelper::remove($closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($closeButton, 'label', '&times;');

            Html::addCssClass($closeButton, ['close' => 'modal-close']);

            if ($tag === 'button' && !isset($closeButton['type'])) {
                $closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $closeButton);
        } else {
            return null;
        }
    }

    /**
     * Renders the Modal footer.
     * @return string the rendered markup of the footer.
     * @uses [[renderCloseButton()]]
     */
    protected function renderFooter()
    {
        if (!$this->footer &&
            $this->closeButtonPosition != self::CLOSE_BUTTON_POSITION_BEFORE_FOOTER &&
            $this->closeButtonPosition != self::CLOSE_BUTTON_POSITION_AFTER_FOOTER) {
            return '';
        }

        $html = [];
        Html::addCssClass($this->footerOptions, ['footer' => 'modal-footer']);
        $html[] = Html::beginTag('div', $this->footerOptions);

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_BEFORE_FOOTER) {
            $html[] = $this->renderCloseButton();
        }

        $html[] = $this->footer;

        if ($this->closeButtonPosition === self::CLOSE_BUTTON_POSITION_AFTER_FOOTER) {
            $html[] = $this->renderCloseButton();
        }

        $html[] = Html::endTag('div');

        return implode("\n", $html);
    }

    /**
     * Set inital default options.
     */
    protected function initDefaults()
    {
        switch ($this->modalType) {
            case self::TYPE_FIXED_FOOTER:
                Html::addCssClass($this->options, ['modalType' => 'modal-fixed-footer']);
                break;

            case self::TYPE_BOTTOM_SHEET:
                Html::addCssClass($this->options, ['modalType' => 'bottom-sheet']);
                break;

            default:
                break;
        }

        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->closeButton !== false) {
            $this->closeButton = ArrayHelper::merge([
                'class' => 'modal-close',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== false) {
            $this->toggleButton = ArrayHelper::merge([
                'class' => 'modal-trigger btn',
            ], $this->toggleButton);
        }

        $this->clientOptions['opacity'] = $this->overlayOpacity;
        $this->clientOptions['inDuration'] = $this->inDuration;
        $this->clientOptions['outDuration'] = $this->outDuration;
        $this->clientOptions['preventScrolling'] = $this->preventScrolling;
        $this->clientOptions['dismissible'] = $this->dismissible;
        $this->clientOptions['startingTop'] = $this->startingTopOffset;
        $this->clientOptions['endingTop'] = $this->endingTopOffset;
    }
}
