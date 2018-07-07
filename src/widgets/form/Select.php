<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

/**
 * Select renders a `<select>` option list and utilizes Materialize `material_select()` to display a highly user-friendly
 * drop down.
 *
 * @package widgets
 * @subpackage form
 * @since 1.2.0
 */
class Select extends BaseInputWidget
{
    /**
     * @var array the items for the select to display.
     *
     * The array keys are the `<option>` values whereas the array values are either the `<option>` labels or can be used to define
     * options for the resulting `<option>` tag.
     *
     * ```php
     *  $items = [
     *      // here we have a simple key-value pair
     *      1 => 'Option 1',
     *
     *      // Here further options for the <option> tag are provided. Every key-value pair in 'options' will be rendered
     *      // as a tag attribute in the resulting <option> tag.
     *      2 => [
     *          'label' => 'Option 2',
     *
     *          // The 'data-icon' and 'class' attributes are Materialize specific. Refer to http://materializecss.com/forms.html#select
     *          // for information about adding icons to select options.
     *          'options' => [
     *              'data-icon' => 'http://lorempixel.com/40/40/people/1',
     *              'class' => 'circle right'
     *          ],
     *      ],
     *
     *      // If you provide an array as value and do not have an 'option' key present, the value will be treated as nested
     *      // values. Every rule explained above applies to the sub-array. Every array value will be rendered as an <option>
     *      // tag and all resulting <options> will be encapsulated in an <optgroup> tag.
     *      3 => [
     *          31 => [
     *              'label' => 'Option 3.1',
     *              'options' => [
     *                  'data-icon' => 'http://lorempixel.com/40/40/people/3',
     *                  'class' => 'circle right'
     *              ],
     *          ],
     *          32 => 'Option 3.2'
     *      ],
     *  ];
     * ```
     *
     * The above example will result in the following HTML:
     *
     * ```
     *  <select>
     *      <option class="circle right" value="1" data-icon="http://lorempixel.com/40/40/people/1">Option 1</option>
     *      <option value="2" label="Option 2">Option 2</option>
     *
     *      <optgroup label="3">
     *          <option class="circle right" value="31" data-icon="http://lorempixel.com/40/40/people/3">Option 3.1</option>
     *          <option value="32" label="Option 3.2">Option 3.2</option>
     *      </optgroup>
     *  </select>
     * ```
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#activeDropDownList()-detail
     * @see https://materializecss.com/select.html
     */
    public $items = [];

    /**
     * @var array the HTML attributes for the widget container tag.
     *
     * The following special options are recognized:
     * - placeholder: the blank option label. Set this to 'false' to prevent the blank option to be rendered.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var boolean whether the select shall allow multiple selections.
     *
     * Please note: this options takes precedence over the 'multiple' key in [[$options]]
     *
     * @since 1.2.1
     */
    public $multiple = false;

    /**
     * @var string the default placeholder string.
     */
    protected $defaultPlaceholder = 'Please choose';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['options'])) {
            $this->options['options'] = [];
        }

        $this->options['multiple'] = $this->multiple;

        $this->parseItems();
        $this->insertPlaceholder();

        $this->registerPlugin('FormSelect');
    }

    /**
     * Executes the widget.
     * @return string the rendered markup.
     */
    public function run()
    {
        if ($this->hasModel()) {
            $html = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            $html = Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }

        return $html;
    }

    /**
     * Inserts a blank option at the beginning of the options list.
     * To prevent this blank option to be rendered, simply set the 'placeholder' key of [[options]] to `false`.
     */
    protected function insertPlaceholder()
    {
        $placeholder = ArrayHelper::remove($this->options, 'placeholder', $this->defaultPlaceholder);

        if ($placeholder !== false) {
            $this->items = ArrayHelper::merge(['' => $placeholder], $this->items);

            $placeholderOption = [
                '' => ['disabled' => true],
            ];
            $this->options['options'] = ArrayHelper::merge($placeholderOption, $this->options['options']);
        }
    }

    /**
     * Parses all items.
     *
     * @uses [[parseItem()]]
     */
    protected function parseItems()
    {
        $items = $this->items;
        $this->items = [];

        foreach ($items as $optionValue => $item) {
            $this->parseItem($optionValue, $item);
        }
    }

    /**
     * Parses a single item.
     * Uses recursion to determine nested value options, which will then be rendered inside <optgroups>.
     *
     * Please refer to
     * [yii\helpers\BaseHtml::activeDropDownList()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#activeDropDownList()-detail)
     * for details on `$options` and `$items`.
     *
     * @param mixed $optionValue the value of the option.
     * @param mixed $item the current item to be parsed.
     * @param mixed|null $parentKey the parent option's key if a nested value is currently parsed.
     */
    protected function parseItem($optionValue, $item, $parentKey = null)
    {
        if (is_array($item)) {
            if (ArrayHelper::keyExists('options', $item)) {
                $label = ArrayHelper::getValue($item, 'label');
                $optionOptions = ArrayHelper::getValue($item, 'options', []);
                $this->addItem($optionValue, $label, $parentKey);
                $this->addItemOption($optionValue, $optionOptions);
            } else { // nested values -> optgroup
                foreach ($item as $subOptionValue => $subItem) {
                    $this->parseItem($subOptionValue, $subItem, $optionValue);
                }
            }
        } else {
            $this->addItem($optionValue, $item, $parentKey);
            $this->addItemOption($optionValue, ['label' => $item]);
        }
    }

    /**
     * Adds an item value and label to [[$items]].
     *
     * @param mixed $value the value of the option.
     * @param mixed $label the label of the option.
     * @param mixed|null $parentKey the parent option's key if a nested value is being added.
     */
    private function addItem($value, $label, $parentKey = null)
    {
        if ($parentKey) {
            $this->items[$parentKey][$value] = $label;
        } else {
            $this->items[$value] = $label;
        }
    }

    /**
     * Adds option `options` to [[$options]].
     *
     * @param mixed $value the value of the option.
     * @param array $options the attributes for the select option tags.
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#activeDropDownList()-detail
     */
    private function addItemOption($value, $options)
    {
        $this->options['options'] = ArrayHelper::merge($this->options['options'], [$value => $options]);
    }
}
