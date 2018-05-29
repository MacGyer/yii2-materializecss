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
 * Dropdown renders a Materialize dropdown menu component.
 *
 * For example,
 *
 * ```php
 * <div class="dropdown">
 *      <?= \macgyer\yii2materializecss\widgets\navigation\Dropdown::widget([
 *          'items' => [
 *              ['label' => 'DropdownA', 'url' => '/'],
 *              ['label' => 'DropdownB', 'url' => '#'],
 *          ],
 *          'toggleButtonOptions' => [
 *              'label' => 'Drop Me!'
 *          ]
 *      ]); ?>
 * </div>
 * ```
 *
 * produces
 *
 * ```
 * <div class="dropdown">
 *      <button type="button" id="w1" class="dropdown-trigger btn" data-target="w0">Drop Me!</button>
 *      <ul id="w0" class="dropdown-content" tabindex="0">
 *          <li tabindex="0"><a href="/" tabindex="-1">DropdownA</a></li>
 *          <li tabindex="0"><a href="#" tabindex="-1">DropdownB</a></li>
 *      </ul>
 * </div>
 * ```
 *
 * If you are using a custom toggle button, please make sure to correctly set the `data-target` attribute in your toggle button.
 * It has to match the `id` attribute of the dropdown.
 *
 * @see https://materializecss.com/dropdown.html
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

    /**
     * @var array the configuration options for the dropdown toggle button. See [[Button|Button]] for detailed information
     * on available options.
     * To prevent the toggle button from being rendered, set this options to `false`.
     */
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

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getUniqueId('dropdown_');
        }
        Html::addCssClass($this->options, ['widget' => 'dropdown-content']);

        $this->registerPlugin('Dropdown', '.dropdown-trigger');
    }

    /**
     * Renders the widget and registers the plugin asset.
     *
     * @return string the result of widget execution to be outputted.
     * @throws InvalidConfigException
     * @see \macgyer\yii2materializecss\lib\MaterializeWidgetTrait|MaterializeWidgetTrait
     */
    public function run()
    {
        if ($this->toggleButtonOptions !== false) {
            $html[] = $this->renderToggleButton();
        }
        $html[] = $this->renderItems($this->items, $this->options);
        return implode("\n", $html);
    }

    /**
     * Renders the dropdown toggle button.
     *
     * @return string the markup of the toggle button.
     * @throws \Exception
     */
    protected function renderToggleButton()
    {
        if (!isset($this->toggleButtonOptions['options']['data-target'])) {
            $this->toggleButtonOptions['options']['data-target'] = $this->options['id'];
        }
        Html::addCssClass($this->toggleButtonOptions['options'], ['toggle-button' => 'dropdown-trigger']);

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
}
