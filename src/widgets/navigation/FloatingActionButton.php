<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\navigation;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Button;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Floating action buttons (FAB) are sets of actions grouped by a single button.
 *
 * Imagine you have an calendar app with a single "create" button. Your user shall be able to create calendar entries and
 * contacts. Those actions require a dedicated button. For UI reasons you can group both (or as much buttons as you like)
 * single buttons by a "parent" button element. The child buttons can be displayed by hover or click.
 *
 * ```
 * <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
 *    <a class="btn-floating btn-large red">
 *      <i class="large material-icons">mode_edit</i>
 *    </a>
 *    <ul>
 *      <li><a class="btn-floating green"><i class="material-icons">perm_identity</i></a></li>
 *      <li><a class="btn-floating blue"><i class="material-icons">today</i></a></li>
 *    </ul>
 * </div>
 * ```
 *
 * @see https://materializecss.com/floating-action-button.html
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage navigation
 */
class FloatingActionButton extends BaseWidget
{
    /**
     * @var array list of button items in the fixed action button. Each element can be either an HTML string
     * or an array representing a single item with the following specification:
     *
     * - label: string, required, the label of the item link
     * - encodeLabel: boolean, whether the label should be HTML-encoded. Defaults to true.
     * - url: string|array, optional, the url of the item link. This will be processed by [yii\helpers\Url::to()](http://www.yiiframework.com/doc-2.0/yii-helpers-baseurl.html#to()-detail).
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     **/
    public $items = [];

    /**
     * @var boolean whether all labels of the items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var array the HTML attributes for the widget container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the container around the button items.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $itemsContainerOptions = [];

    /**
     * @var boolean whether the button items are only visible after click.
     */
    public $clickToToggle = false;

    /**
     * @var boolean whether to display a horizontal FAB.
     */
    public $horizontal = false;

    /**
     * @var boolean whether to expand FAB as toolbar.
     * @since 1.2.0
     */
    public $toolbar = false;

    /**
     * @var string the tag used to render the button.
     *
     * Should be "a" for correct functionality of [[clickToToggle]] FAB.
     */
    public $buttonTagName = 'a';

    /**
     * @var string the label on the button.
     */
    public $buttonLabel = 'Button';

    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $buttonEncodeLabel = true;

    /**
     * @var array the options for the optional icon.
     * The icon will be rendered by [[\macgyer\yii2materializecss\widgets\Icon|Icon]].
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
     */
    public $buttonIcon;

    /**
     * @var array the HTML attributes for the visible button.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $buttonOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'fixed-action-btn']);
        Html::addCssClass($this->buttonOptions, ['widget' => 'btn-floating']);

        if ($this->clickToToggle) {
            $this->clientOptions['hoverEnabled'] = false;
        }

        if ($this->horizontal) {
            $this->clientOptions['direction'] = 'left';
            Html::addCssClass($this->options, ['containerLayout' => 'horizontal']);
        }

        if ($this->toolbar) {
            $this->clientOptions['toolbarEnabled'] = true;
            Html::addCssClass($this->options, ['toolbar' => 'toolbar']);
        }

        $this->registerPlugin('FloatingActionButton');
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @throws InvalidConfigException
     * @throws \Exception
     * @see  Button|Button
     */
    public function run()
    {
        $html[] = Html::beginTag('div', $this->options);

        // Visible button
        $html[] = Button::widget([
            'tagName' => $this->buttonTagName,
            'label' => $this->buttonLabel,
            'encodeLabel' => $this->buttonEncodeLabel,
            'options' => $this->buttonOptions,
            'icon' => $this->buttonIcon
        ]);

        $html[] = $this->renderItems();
        $html[] = Html::endTag('div');

        return implode("\n", $html);
    }

    /**
     * Renders a list representing the single button items.
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

            $encodeLabel = isset($item['encodeLabel']) ? $item['encodeLabel'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            Html::addCssClass($linkOptions, ['link' => 'btn-floating']);

            $url = array_key_exists('url', $item) ? $item['url'] : '#';
            $content = Html::a($label, $url, $linkOptions);

            $elements[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $elements), $this->itemsContainerOptions);
    }
}
