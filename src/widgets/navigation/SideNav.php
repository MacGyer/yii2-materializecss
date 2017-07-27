<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\navigation;

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Button;
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
     * @var array the configuration options for the toggle button.
     * The toggle button is rendered by the [[Button]] widget. See the docs for all available options.
     *
     * @see Button|Button
     */
    public $toggleButtonOptions = [];

    /**
     * Initializes the widget.
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->options['id'] = $this->getToggleId();
        Html::addCssClass($this->options, ['widget' => 'side-nav']);

        if (!$this->toggleButtonOptions) {
            $this->toggleButtonOptions = [
                'label' => '',
                'icon' => [
                    'name' => 'menu'
                ],
                'type' => Button::TYPE_FLAT,
            ];
        }

        Html::addCssClass($this->toggleButtonOptions['options'], ['toggleButton' => 'sidenav-toggle']);
        $this->toggleButtonOptions['options']['data-activates'] = $this->options['id'];
    }

    /**
     * Executes the widget.
     * @return string
     * @uses [[registerClientScript]]
     * @uses [[renderItems]]
     */
    public function run()
    {
        $this->registerClientScript();

        $html[] = $this->renderToggleButton();
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
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            $toggleTarget = 'dropdown_' . md5(uniqid());
            $linkOptions['data-activates'] = $toggleTarget;
            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-button']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item, $toggleTarget);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * Renders the side navigation toggle button.
     *
     * @see Button|Button
     * @return string
     */
    protected function renderToggleButton()
    {
        return Button::widget($this->toggleButtonOptions);
    }

    /**
     * Registers the Materialize SideNav client plugin.
     */
    protected function registerClientScript()
    {
        $this->registerPlugin('sideNav', '.sidenav-toggle');
    }

    /**
     * Generates unique element ID.
     * @return string
     */
    protected function getToggleId()
    {
        $unique = md5(uniqid());
        return "sidenav_$unique";
    }
}
