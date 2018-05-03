<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\media;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * MaterialBox creates a lightweight lightbox variant to present images.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage media
 *
 * @see https://materializecss.com/media.html#materialbox
 */
class MaterialBox extends BaseWidget
{
    /**
     * @var string the source of the image.
     * You must either specify this option or provide an image source via [[$imageOptions]].
     */
    public $imageSrc;

    /**
     * @var array the HTML attributes for the image tag.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $imageOptions = [];

    /**
     * @var string|false the caption of the image.
     * If you do not want a caption to be rendered, set this option to `false`.
     */
    public $imageCaption = false;

    /**
     * @var boolean whether the image caption shall be HTML-encoded. This defaults to `true`.
     */
    public $encodeImageCaption = true;

    /**
     * Initialize the widget.
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->imageSrc) {
            $imageSrc = ArrayHelper::remove($this->imageOptions, 'src', null);
            if (!$imageSrc) {
                throw new InvalidConfigException("Image src must be defined.");
            }

            $this->imageSrc = $imageSrc;
        }

        Html::addCssClass($this->imageOptions, ['plugin' => 'materialboxed']);

        if ($this->imageCaption !== false) {
            $this->imageOptions['data-caption'] = $this->encodeImageCaption ? Html::encode($this->imageCaption) : $this->imageCaption;
        }
    }

    /**
     * Execute the widget.
     * @return string the widget's markup.
     */
    public function run()
    {
        $this->registerPlugin('Materialbox', '.materialboxed');

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $html[] = Html::beginTag($tag, $this->options);

        $html[] = Html::img($this->imageSrc, $this->imageOptions);

        $html[] = Html::endTag($tag);

        return implode("\n", $html);
    }
}
