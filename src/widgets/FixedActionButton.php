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
 * Class FixedActionButton
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 */
class FixedActionButton extends BaseWidget
{
    /**
     * @var array list of button items in the fixed action button. Each element can be either an HTML string
     * or an array representing a single item with the following specification:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     **/
    public $items;

    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'fixed-action-btn'];

    /**
     * @var array the HTML attributes for the container around the button items
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $itemsContainerOptions = [];

    /**
     * @var bool whether the button items are only visible after click
     */
    public $clickToToggle = false;

    /**
     * @var bool whether to display a horizontal FAB
     */
    public $horizontal = false;

    /**
     * @var string the tag used to render the button
     *
     * Should be a for correct functionality of click to toggle FAB
     */
    public $buttonTagName = 'a';

    /**
     * @var string the label on the button
     */
    public $buttonLabel = 'Button';

    /**
     * @var bool whether the label should be HTML-encoded.
     */
    public $buttonEncodeLabel = true;

    /**
     * @var array the options for the optional icon
     *
     * To specify an icon you can use the following parameters
     *
     * ```php
     * [
     *     'name' => 'name of the icon',                    // required
     *     'position' => 'position of the icon',            // optional, 'left' or 'right', defaults to 'left'
     *     'options' => 'the HTML attributes for the img',  // optional
     * ]
     * ```
     */
    public $buttonIcon;

    /**
     * @var array the HTML attributes for the visible button
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $buttonOptions = [];

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->buttonOptions, ['widget' => 'btn-floating']);

        if ($this->clickToToggle) {
            Html::addCssClass($this->options, ['container' => 'click-to-toggle']);
        }

        if ($this->horizontal) {
            Html::addCssClass($this->options, ['containerLayout' => 'horizontal']);
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $html = Html::beginTag('div', $this->options);

        // Visible button
        $html .= Button::widget([
            'tagName' => $this->buttonTagName,
            'label' => $this->buttonLabel,
            'encodeLabel' => $this->buttonEncodeLabel,
            'options' => $this->buttonOptions,
            'icon' => $this->buttonIcon
        ]);

        $html .= $this->renderItems();
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    protected function renderItems()
    {
        $elements = [];
        $items = $this->items;

        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            if (is_string($item)) {
                $elements[] = $item;
                continue;
            }

            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }

            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if ($url === null) {
                $content = $label;
            } else {
                $content = Html::a($label, $url, $linkOptions);
            }

            $elements[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $elements), $this->itemsContainerOptions);
    }
}
