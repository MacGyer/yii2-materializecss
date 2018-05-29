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
 * Slider renders a Materialize image slider with optional captions.
 *
 * Simply provide the [[slides]] as an array of items.
 * For each item you must define the `image` key with the image's `src`. Additionally you can define and align a caption
 * for every slide individually. Caption content can be HTML and will <strong>not</strong> be encoded.
 *
 * ```php
 * 'slideOptions' => [
 *      'class' => 'slide-item' // this class will be used for all slide elements (<li>)
 * ],
 * 'slides' => [
 *      [
 *          'image' => ['src' => '/source/of/image'],
 *      ],
 *      [
 *          'image' => ['src' => '/source/of/image'],
 *          'caption' => [
 *              'content' => '<p>Caption content</p>',
 *              'align' => Slider::CAPTION_ALIGN_RIGHT
 *          ],
 *          'options' => ['class' => 'slide-item-override'] // overrides $slideOptions
 *      ]
 * ]
 * ```
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage media
 *
 * @see http://nextmaterializecss.com/media.html#slider
 */
class Slider extends BaseWidget
{
    /**
     * Sets the caption alignment to `left`.
     */
    const CAPTION_ALIGN_LEFT = 'left-align';

    /**
     * Sets the caption alignment to `center`.
     */
    const CAPTION_ALIGN_CENTER = 'center-align';

    /**
     * Sets the caption alignment to `right`.
     */
    const CAPTION_ALIGN_RIGHT = 'right-align';

    /**
     * @var array the HTML attributes for the slider container tag.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $sliderOptions = [];

    /**
     * @var array the HTML attributes for each slider's `<li>` tag.
     * These options will be merged with the individual slide options.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $slideOptions = [];

    /**
     * @var array the HTML attributes for each caption.
     * These options will be merged with the individual caption options.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $captionOptions = [];

    /**
     * @var array the slide items.
     * Provide a sub-array for each slide which contains at least the `image` key for the image options. Every image must
     * have a `src` with the image's URL.
     */
    public $slides = [];

    /**
     * @var boolean whether to show the slider's navigation indicators.
     */
    public $showIndicators = true;

    /**
     * @var boolean whether this is a fullscreen slider.
     */
    public $fullscreen = false;

    /**
     * @var int the slider height.
     */
    public $height = 400;

    /**
     * @var int the duration of the transition animation in ms.
     */
    public $duration = 500;

    /**
     * @var int the duration each slide is shown in ms.
     */
    public $interval = 6000;

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->sliderOptions, ['plugin' => 'slider']);

        if ($this->fullscreen === true) {
            Html::addCssClass($this->sliderOptions, ['fullscreen' => 'fullscreen']);
        }

        $this->clientOptions['indicators'] = $this->showIndicators;
        $this->clientOptions['height'] = $this->height;
        $this->clientOptions['duration'] = $this->duration;
        $this->clientOptions['interval'] = $this->interval;

        $this->registerPlugin('Slider', '.slider');
    }

    /**
     * Execute the widget.
     * @return string the rendered markup
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->options);
        $html[] = Html::beginTag('div', $this->sliderOptions);
        $html[] = $this->renderSlides();
        $html[] = Html::endTag('div');
        $html[] = Html::endTag($tag);

        return implode("\n", $html);
    }

    /**
     * Parses all [[slides]] and generates the slide list.
     * @return string the list markup
     */
    protected function renderSlides()
    {
        $slides = [];
        foreach ($this->slides as $slide) {
            $slides[] = $this->renderSlide($slide);
        }
        $html[] = Html::tag('ul', implode("\n", $slides), ['class' => 'slides']);
        return implode("\n", $html);
    }

    /**
     * Renders a single slide.
     *
     * @param array $slideConfig the configuration for the slide
     * @return string the slide's markup
     */
    protected function renderSlide($slideConfig = [])
    {
        $imageOptions = ArrayHelper::getValue($slideConfig, 'image', []);
        $imageSrc = ArrayHelper::remove($imageOptions, 'src', null);
        if (!$imageSrc) {
            return '';
        }

        $caption = $this->renderCaption(ArrayHelper::getValue($slideConfig, 'caption', false));
        $options = ArrayHelper::getValue($slideConfig, 'options', []);
        $options = ArrayHelper::merge($this->slideOptions, $options);

        $html[] = Html::beginTag('li', $options);
        $html[] = Html::img($imageSrc, $imageOptions);
        $html[] = $caption;
        $html[] = Html::endTag('li');
        return implode("\n", $html);
    }

    /**
     * Renders the caption markup.
     * @param false|array $captionConfig the caption configuration data
     * @return string the markup of the caption
     */
    protected function renderCaption($captionConfig)
    {
        if ($captionConfig === false) {
            return '';
        }

        $content = ArrayHelper::getValue($captionConfig, 'content', '');
        $alignment = ArrayHelper::getValue($captionConfig, 'align', null);
        $options = ArrayHelper::getValue($captionConfig, 'options', []);
        $options = ArrayHelper::merge($this->captionOptions, $options);

        Html::addCssClass($options, ['caption' => 'caption']);
        if ($alignment) {
            Html::addCssClass($options, ['align' => $alignment]);
        }

        return Html::tag('div', $content, $options);
    }
}
