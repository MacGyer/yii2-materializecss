<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\navigation;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Button;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Dropdown renders a Materialize dropdown menu component.
 *
 * For example,
 *
 * ```php
 * <div class="dropdown">
 *     <a class="dropdown-button" href="#!" data-activates="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a>
 *     <?php
 *         echo Dropdown::widget([
 *             'items' => [
 *                 ['label' => 'DropdownA', 'url' => '/'],
 *                 ['label' => 'DropdownB', 'url' => '#'],
 *             ],
 *             'toggleTarget' => 'dropdown1'
 *         ]);
 *     ?>
 * </div>
 * ```
 *
 * Please make sure that you provide the trigger with a `data-activates` attribute and specify the value of this attribute
 * in the [[toggleTarget]] property of the widget.
 *
 * @see http://materializecss.com/navbar.html#navbar-dropdown
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage navigation
 */
class Dropdown extends BaseWidget
{
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [yii\helpers\Url::to()](http://www.yiiframework.com/doc-2.0/yii-helpers-baseurl.html#to()-detail).
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - submenuOptions: array, optional, the HTML attributes for sub-menu container tag. If specified it will be
     *   merged with [[submenuOptions]].
     *
     * To insert a divider use `<li class="divider"></li>`.
     */
    public $items = [];

    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var array|null the HTML attributes for sub-menu container tags.
     * If not set - [[options]] value will be used for it.
     */
    public $submenuOptions;

    public $toggleButtonOptions = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        if ($this->submenuOptions === null) {
            $this->submenuOptions = $this->options;
            unset($this->submenuOptions['id']);
        }
        parent::init();

        $this->options['id'] = $this->getUniqueId();
        Html::addCssClass($this->options, ['widget' => 'dropdown-content']);

        if (!isset($this->toggleButtonOptions['options']['data-target'])) {
            $this->toggleButtonOptions['options']['data-target'] = $this->options['id'];
        }
        Html::addCssClass($this->toggleButtonOptions['options'], ['toggle-button' => 'dropdown-trigger']);

        $this->registerPlugin('Dropdown', '.dropdown-trigger');
    }

    /**
     * Renders the widget and registers the plugin asset.
     *
     * @return string the result of widget execution to be outputted.
     * @throws InvalidConfigException
     * @see MaterializePluginAsset|MaterializePluginAsset
     * @see \macgyer\yii2materializecss\lib\MaterializeWidgetTrait|MaterializeWidgetTrait
     */
    public function run()
    {
        $html[] = $this->renderToggleButton();
        $html[] = $this->renderItems($this->items, $this->options);
        return implode("\n", $html);
    }

    protected function renderToggleButton()
    {
        $this->toggleButtonOptions['tagName'] = 'a';

        return Button::widget($this->toggleButtonOptions);
    }

    /**
     * Renders menu items.
     *
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $linkOptions['tabindex'] = '-1';
            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass($itemOptions, ['widget' => 'dropdown-header']);
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
            } else {
                $submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                $content = Html::a($label, $url === null ? '#' : $url, $linkOptions)
                    . $this->renderItems($item['items'], $submenuOptions);
                Html::addCssClass($itemOptions, ['widget' => 'dropdown-submenu']);
            }

            $lines[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $lines), $options);
    }

    /**
     * @return string
     */
    private function getUniqueId()
    {
        $uniqid = sha1(uniqid('dropdown_', true));
        return "dropdown_$uniqid";
    }
}
