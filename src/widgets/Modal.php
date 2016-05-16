<?php

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

/**
 * Class Modal
 * @package macgyer\yii2materializecss\widgets
 */
class Modal extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string the different modal types
     *
     * The following options are supported
     *
     * - lean (default)
     * - fixedFooter
     * - bottomSheet
     *
     * @see http://materializecss.com/modals.html
     */
    public $modalType = 'lean'; // fixedFooter | bottomSheet

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
     */
    public $closeButton = [];

    /**
     * @var string the position of the close button
     *
     * The following options are supported:
     *
     * - beforeContent
     * - afterContent
     * - beforeFooter
     * - afterFooter
     * - precedeContainer
     * - succeedContainer
     *
     * Defaults to 'beforeContent'.
     */
    public $closeButtonPosition = 'beforeContent'; // afterContent | beforeFooter | afterFooter | precedeContainer | succeedContainer

    /**
     * @var array the options for rendering the toggle button tag.
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
     */
    public $toggleButton = [];

    /**
     * @var string the content of the footer
     */
    public $footer;

    /**
     * @var array the optional HTML attributes for the footer container
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $footerOptions = [];

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        $this->initDefaults();

        $options = $this->options;

        $html = $this->renderToggleButton();

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html .= Html::beginTag($tag, $options);

        if ($this->closeButtonPosition === 'precedeContainer') {
            $html .= $this->renderCloseButton();
        }

        $html .= Html::beginTag('div', ['class' => 'modal-content']);

        if ($this->closeButtonPosition === 'beforeContent') {
            $html .= $this->renderCloseButton();
        }

        echo $html;

        $this->registerPlugin('leanModal', '.modal-trigger');
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $options = $this->options;
        $html = '';

        if ($this->closeButtonPosition === 'afterContent') {
            $html = $this->renderCloseButton();
        }

        $html .= Html::endTag('div');

        $html .= $this->renderFooter();

        if ($this->closeButtonPosition === 'succeedContainer') {
            $html .= $this->renderCloseButton();
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $html .= Html::endTag($tag);

        echo $html;
    }

    /**
     * @return null|string
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
     * @return null|string
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
     * @return string
     */
    protected function renderFooter()
    {
        if (!$this->footer) {
            return '';
        }

        Html::addCssClass($this->footerOptions, ['footer' => 'modal-footer']);
        $html = Html::beginTag('div', $this->footerOptions);

        if ($this->closeButtonPosition === 'beforeFooter') {
            $html .= $this->renderCloseButton();
        }

        $html .= $this->footer;

        if ($this->closeButtonPosition === 'afterFooter') {
            $html .= $this->renderCloseButton();
        }

        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Set inital default options.
     */
    protected function initDefaults()
    {
        switch ($this->modalType) {
            case 'fixedFooter':
                Html::addCssClass($this->options, ['modalType' => 'modal-fixed-footer']);
                break;

            case 'bottomSheet':
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

        if ($this->clientOptions !== false) {
            $this->clientOptions = ArrayHelper::merge(['show' => false], $this->clientOptions);
        }
    }
}
