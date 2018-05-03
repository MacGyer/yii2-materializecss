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
 * Collapsibles are accordion elements that expand when clicked on. They allow you to hide content that is not immediately relevant to the user.
 *
 * Simply provide the [[items]] as an array.
 *
 * For each item you can define the `header` and `body` key for header and body configuration.
 * Both `header` and `body` support the following special options:
 * - `tag`: the tag for the container tag, defaults to `div`.
 * - `content`: the content for the respective section. This can be arbitrary HTML.
 *
 * All other options are rendered as HTML attributes.
 *
 * ```php
 * 'type' => Collapsible::TYPE_EXPANDABLE,
 * 'items' => [
 *      [
 *          'header' => [
 *              'content' => '<i class="material-icons">filter_drama</i>First'
 *          ],
 *          'body' => [
 *              'content' => '<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>',
 *          ],
 *      ],
 *      [
 *          'header' => [
 *              'content' => '<i class="material-icons">place</i>Second',
 *              'class' => 'customHeader',
 *          ],
 *          'body' => [
 *              'content' => '<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>',
 *              'tag' => 'p',
 *              'data-body-category' => 'example',
 *          ],
 *          'options' => ['class' => 'active'], // to make this item pre-selected
 *      ],
 * ]
 * ```
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 *
 * @see https://materializecss.com/collapsible.html
 */
class Collapsible extends BaseWidget
{
    /**
     * Sets the [[type]] to `accordion`. Only one item can be opened at the same time.
     */
    const TYPE_ACCORDION = 'accordion';

    /**
     * Sets the [[type]] to `expandable`. More than one item can be opened simultaneously.
     */
    const TYPE_EXPANDABLE = 'expandable';

    /**
     * @var array the list of items. Provide an array for each item. See introductory example for details.
     */
    public $items = [];

    /**
     * @var string the type of the Collapsible.
     * Defaults to `accordion`.
     */
    public $type = self::TYPE_ACCORDION;

    /**
     * @var boolean whether the active item shall pop out of the list.
     */
    public $isPopoutStyle = false;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'collapsible']);

        if ($this->isPopoutStyle) {
            Html::addCssClass($this->options, ['popout' => 'popout']);
        }

        if ($this->type == self::TYPE_EXPANDABLE) {
            $this->clientOptions['accordion'] = false;
        }

        $this->registerPlugin('Collapsible');
    }

    /**
     * Execute the widget.
     * @return string the widget markup
     */
    public function run()
    {
        $items = $this->renderItems();
        return Html::tag('ul', $items, $this->options);
    }

    /**
     * Render the items.
     * @return string the markup for all items
     */
    protected function renderItems()
    {
        $html = [];
        foreach ($this->items as $item) {
            $html[] = $this->renderItem($item);
        }

        return implode("\n", $html);
    }

    /**
     * Render a single item.
     * @param array $item the item configuration
     * @return string the item's markup
     */
    protected function renderItem($item = [])
    {
        $itemOptions = ArrayHelper::getValue($item, 'options', []);

        $headerOptions = ArrayHelper::getValue($item, 'header', []);
        $headerContent = ArrayHelper::remove($headerOptions, 'content');
        $headerTag = ArrayHelper::remove($headerOptions, 'tag', 'div');

        $bodyOptions = ArrayHelper::getValue($item, 'body', []);
        $bodyContent = ArrayHelper::remove($bodyOptions, 'content', []);
        $bodyTag = ArrayHelper::remove($bodyOptions, 'tag', 'div');

        if (!$headerContent && !$bodyContent) {
            return '';
        }

        $html[] = Html::beginTag('li', $itemOptions);
        if ($headerContent) {
            Html::addCssClass($headerOptions, ['header' => 'collapsible-header']);
            $html[] = Html::tag($headerTag, $headerContent, $headerOptions);
        }
        if ($bodyContent) {
            Html::addCssClass($bodyOptions, ['body' => 'collapsible-body']);
            $html[] = Html::tag($bodyTag, $bodyContent, $bodyOptions);
        }
        $html[] = Html::endTag('li');

        return implode("\n", $html);
    }
}
