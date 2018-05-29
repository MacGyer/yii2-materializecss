<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\navigation;

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Button;
use macgyer\yii2materializecss\widgets\Collapsible;
use macgyer\yii2materializecss\widgets\navigation\Nav;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * SideNav renders a side navigation, which is especially useful for mobile devices or small screen sizes.
 *
 * See [[Nav::$items]] for details on item structure.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @see http://materializecss.com/side-nav.html
 * @package widgets
 * @subpackage navigation
 */
class SideNav extends Nav
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - dropDownOptions: array, optional, the HTML options that will passed to the [[Dropdown]] widget.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     * - encode: boolean, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];

    /**
     * @var array the options for the underlying JS sideNav() plugin.
     * The following options are supported:
     * - menuWidth: 300, // Default is 240
     * - edge: 'right', // Choose the horizontal origin
     * - closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
     * - draggable: true // Choose whether you can drag to open on touch screens
     *
     * @see http://materializecss.com/side-nav.html#options
     */
    public $clientOptions = [];

    /**
     * @var bool whether the toggle button shall be rendered.
     */
    public $renderToggleButton = true;

    /**
     * @var array the configuration options for the toggle button.
     * The toggle button is rendered by the [[Button]] widget. See the docs for all available options.
     *
     * @see Button|Button
     */
    public $toggleButtonOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->activateParents = true;

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getUniqueId('sidenav_');
        }
        Html::addCssClass($this->options, ['widget' => 'sidenav']);

        if ($this->renderToggleButton) {
            $this->toggleButtonOptions = ArrayHelper::merge([
                'label' => false,
                'icon' => [
                    'name' => 'menu'
                ],
                'type' => Button::TYPE_FLAT,
            ], $this->toggleButtonOptions);

            Html::addCssClass($this->toggleButtonOptions['options'], ['toggleButton' => 'sidenav-trigger']);
            $this->toggleButtonOptions['options']['data-target'] = $this->options['id'];
        }

        $this->registerPlugin('Sidenav', '.sidenav');
    }

    /**
     * Executes the widget.
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        if ($this->renderToggleButton) {
            $html[] = $this->renderToggleButton();
        }
        $html[] = $this->renderItems();

        return implode("\n", $html);
    }

    /**
     * Renders widget items.
     */
    protected function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    protected function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $listItemOptions = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $content = Html::a($label, $url, $linkOptions);
        } else {
            Html::addCssClass($listItemOptions, ['widget' => 'submenu']);
            Html::addCssClass($linkOptions, ['widget' => 'submenu-opener']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderCollapsible(Html::a($label, $url, $linkOptions), $items, $active);
            }
            $content = $items;
        }


        if ($this->activateItems && $active) {
            Html::addCssClass($listItemOptions, 'active');
        }

        return Html::tag('li', $content, $listItemOptions);
    }

    /**
     * Renders a submenu as Collapsible in side navigation element.
     *
     * @param string $link the trigger link.
     * @param array $items the submenu items.
     * @param bool $isParentActive whether the submenu's parent list element shall get an 'active' state.
     * @return string the Collapsible markup.
     *
     * @throws \Exception
     */
    protected function renderCollapsible($link, $items = [], $isParentActive = false)
    {
        $itemOptions = [];
        if ($isParentActive) {
            Html::addCssClass($itemOptions, ['item-activation' => 'active']);
        }

        $collapsibleItems = [
            [
                'header' => ['content' => $link],
                'body' => ['content' => $this->buildCollapsibleBody($items)],
                'options' => $itemOptions
            ],
        ];

        return Collapsible::widget([
            'items' => $collapsibleItems,
            'type' => Collapsible::TYPE_ACCORDION,
        ]);
    }

    /**
     * Build the needed markup for the collapsible body, i. e. the `<ul>` containing the submenu links.
     *
     * @param array $items the submenu items.
     * @return string the Collapsible body markup.
     */
    protected function buildCollapsibleBody($items = [])
    {
        $html[] = Html::beginTag('ul');

        foreach ($items as $item) {
            $url = ArrayHelper::getValue($item, 'url', null);
            $label = ArrayHelper::getValue($item, 'label', '');
            $options = ArrayHelper::getValue($item, 'options', []);
            $link = Html::a($label, $url, $options);
            $html[] = Html::tag('li', $link);
        }

        $html[] = Html::endTag('ul');
        return implode("\n", $html);
    }

    /**
     * Renders the side navigation toggle button.
     *
     * @see Button|Button
     * @return string
     * @throws \Exception
     */
    protected function renderToggleButton()
    {
        return Button::widget($this->toggleButtonOptions);
    }
}
