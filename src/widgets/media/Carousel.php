<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\media;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;

/**
 * Carousel is a robust and versatile component that can be an image slider or an item carousel with arbitrary HTML content.
 *
 * Simply provide the [[items]] as an array of items.
 * For each item you must define the `image` key with the image's `src`. Additionally you can define and align a caption
 * for every slide individually. Caption content can be HTML and will <strong>not</strong> be encoded.
 *
 * ```php
 * 'itemOptions' => [
 *      'class' => 'amber white-text' // this class will be used for all carousel elements
 * ],
 * 'items' => [
 *      [
 *          'content' => Html::img('http://lorempixel.com/800/800/sports/2'),
 *      ],
 *      [
 *          'content' => '<h2>Carousel item heading</h2><p>Arbitrary content</p>'
 *          'options' => ['class' => 'carusel-item-override'] // overrides $itemOptions
 *      ]
 * ],
 * 'fixedItemOptions' => [
 *      'tag' => 'p',
 *      'content' => 'Some content',
 * ],
 * ```
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage media
 *
 * @see http://materializecss.com/carousel.html
 */
class Carousel extends BaseWidget
{
    /**
     * @var array the HTML attributes for the carousel container tag.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $carouselOptions = [];

    /**
     * @var array the HTML attributes for each carousel item's tag.
     * These options will be merged with the individual item options.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $itemOptions = [];

    /**
     * @var false|array the configuration for the fixed item.
     *
     * The following special options are recognized:
     * - tag: the fixed item's HTML tag name
     * - content: the content of the fixed item. Please note: this can be HTML and will not be encoded.
     *
     * If you do not want the fixed item to be rendered, set this option to `false`.
     * @see http://materializecss.com/carousel.html#special
     */
    public $fixedItemOptions = false;

    /**
     * @var array the carousel items.
     * Provide a sub-array for each item which can have the keys `tag`, `content` and `options`.
     */
    public $items = [];

    /**
     * @var int transition duration in milliseconds.
     */
    public $duration = 200;

    /**
     * @var int if 0, all items are the same size.
     */
    public $perspectiveZoom = -100;

    /**
     * @var int sets the spacing of the center item.
     */
    public $centerSpacing = 0;

    /**
     * @var int sets the padding between non center items.
     */
    public $padding = 0;

    /**
     * @var int sets the number of items visible.
     */
    public $visibleItems = 5;

    /**
     * @var boolean whether the carousel has full width.
     */
    public $fullWidth = false;

    /**
     * @var boolean whether to show navigation indicators.
     */
    public $showIndicators = false;

    /**
     * @var boolean whether to start with first slide at the end.
     * @see http://materializecss.com/carousel.html#options
     */
    public $noWrap = false;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->carouselOptions, ['plugin' => 'carousel']);
        if ($this->fullWidth) {
            Html::addCssClass($this->carouselOptions, ['fullwidth' => 'carousel-slider']);
            $this->clientOptions['fullWidth'] = true;
        }

        $this->clientOptions['noWrap'] = $this->noWrap;
        $this->clientOptions['indicators'] = $this->showIndicators;
        $this->clientOptions['duration'] = $this->duration;
        $this->clientOptions['dist'] = $this->perspectiveZoom;
        $this->clientOptions['shift'] = $this->centerSpacing;
        $this->clientOptions['padding'] = $this->padding;
        $this->clientOptions['numVisible'] = $this->visibleItems;

        $this->registerPlugin('Carousel', '.carousel');
    }

    /**
     * Execute the widget.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->options);
        $html[] = Html::beginTag('div', $this->carouselOptions);
        $html[] = $this->renderFixedItem();
        $html[] = $this->renderItems();
        $html[] = Html::endTag('div');
        $html[] = Html::endTag($tag);

        return implode("\n", $html);
    }

    /**
     * Parses all [[items]] and renders item list.
     *
     * @return string the item list markup
     */
    protected function renderItems()
    {
        if (!$this->items) {
            return '';
        }

        $html = [];

        foreach ($this->items as $item) {
            $html[] = $this->renderItem($item);
        }

        return implode("\n", $html);
    }

    /**
     * Renders a single carousel item.
     *
     * @param array $item the item configuration
     * @return string the item markup
     */
    protected function renderItem($item = [])
    {
        $tag = ArrayHelper::getValue($item, 'tag', 'div');
        $content = ArrayHelper::getValue($item, 'content', '');
        $options = ArrayHelper::getValue($item, 'options', []);
        $options = ArrayHelper::merge($this->itemOptions, $options);

        Html::addCssClass($options, ['item' => 'carousel-item']);

        return Html::tag($tag, $content, $options);
    }

    /**
     * Renders the optional fixed item.
     *
     * @return string the fixed item's markup
     */
    protected function renderFixedItem()
    {
        if ($this->fixedItemOptions === false) {
            return '';
        }

        $tag = ArrayHelper::remove($this->fixedItemOptions, 'tag', 'div');
        $content = ArrayHelper::remove($this->fixedItemOptions, 'content', '');

        Html::addCssClass($this->fixedItemOptions, ['fixed-item' => 'carousel-fixed-item']);

        return Html::tag($tag, $content, $this->fixedItemOptions);
    }
}
