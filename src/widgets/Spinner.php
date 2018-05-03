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
 * Spinner renders a circular loading animation.
 *
 * When displaying a spinner you can choose to let the colors change with every rotation.
 *
 * @see Progress|Progress
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @since 1.0.2
 * @package widgets
 */
class Spinner extends BaseWidget
{
    /**
     * Sets the [[size]] of the spinner to "small".
     */
    const SIZE_SMALL = 10;

    /**
     * Sets the [[size]] of the spinner to "medium". This is the default setting.
     */
    const SIZE_MEDIUM = 20;

    /**
     * Sets the [[size]] of the spinner to "big".
     */
    const SIZE_BIG = 30;

    /**
     * Sets the [[color]] of the spinner to "red".
     */
    const COLOR_RED = 10;

    /**
     * Sets the [[color]] of the spinner to "blue".
     */
    const COLOR_BLUE = 20;

    /**
     * Sets the [[color]] of the spinner to "yellow".
     */
    const COLOR_YELLOW = 30;

    /**
     * Sets the [[color]] of the spinner to "green".
     */
    const COLOR_GREEN = 40;

    /**
     * @var array the HTML attributes for the widget container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the spinner.
     *
     * If [[flashColors]] is set to "true" these options will be applied to all spinner simultaneously.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail)
     * for details on how attributes are being rendered.
     */
    public $spinnerOptions = [];

    /**
     * @var boolean whether to show alternating colors in spinner.
     *
     * If this is set to "true" the spinner will continously alternate its colors between blue, red, yellow and green.
     *
     * @see https://materializecss.com/preloader.html
     */
    public $flashColors = false;

    /**
     * @var string the size of the spinner.
     *
     * The following options are supported:
     * - small
     * - medium
     * - big
     *
     * Defaults to "medium".
     * To set the size, use the corresponding `SIZE_*` constant of this class.
     */
    public $size = self::SIZE_MEDIUM;

    /**
     * @var integer the color of the spinner.
     *
     * The following options are supported:
     * - blue
     * - red
     * - yellow
     * - green
     *
     * To set the color, use the corresponding `COLOR_*` constant of this class.
     * If no color from this range is given, the slider color will be the Materialize default "petrol" color (#26a69a).
     */
    public $color;

    /**
     * @var array the colors alternating when $flashColors equals 'true'
     */
    private $colors = [
        self::COLOR_BLUE => 'blue',
        self::COLOR_RED => 'red',
        self::COLOR_YELLOW => 'yellow',
        self::COLOR_GREEN => 'green',
    ];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'preloader-wrapper active']);
        Html::addCssClass($this->spinnerOptions, ['spinner' => 'spinner-layer']);

        switch ($this->size) {
            case self::SIZE_SMALL:
                Html::addCssClass($this->options, ['spinner-size' => 'small']);
                break;

            case self::SIZE_BIG:
                Html::addCssClass($this->options, ['spinner-size' => 'big']);
                break;
        }

        if ($this->flashColors === false && $this->color) {
            $color = ArrayHelper::getValue($this->colors, $this->color);
            Html::addCssClass($this->spinnerOptions, ['spinner-color' => "spinner-$color-only"]);
        }
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     * @uses [[renderSpinner()]]
     */
    public function run()
    {
        $html[] = Html::beginTag('div', $this->options);

        if ($this->flashColors !== false) {
            foreach ($this->colors as $color) {
                Html::addCssClass($this->spinnerOptions, ['color' => 'spinner-' . $color]);

                $html[] = Html::beginTag('div', $this->spinnerOptions);
                $html[] = $this->renderSpinner();
                $html[] = Html::endTag('div');

                Html::removeCssClass($this->spinnerOptions, ['color' => 'spinner-' . $color]);
            }
        } else {
            $html[] = Html::beginTag('div', $this->spinnerOptions);
            $html[] = $this->renderSpinner();
            $html[] = Html::endTag('div');
        }

        $html[] = Html::endTag('div');

        return implode("\n", $html);
    }

    /**
     * Renders a single spinner.
     * @return string
     */
    protected function renderSpinner()
    {
        $html = [
            '<div class="circle-clipper left">',
            '<div class="circle"></div>',
            '</div>',
            '<div class="gap-patch">',
            '<div class="circle"></div>',
            '</div>',
            '<div class="circle-clipper right">',
            '<div class="circle"></div>',
            '</div>'
        ];

        return implode("\n", $html);
    }
}
