<?php

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * Class Spinner
 * @package macgyer\yii2materializecss\widgets
 */
class Spinner extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the spinner
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $spinnerOptions = [];

    /**
     * @var bool whether to show alternating colors in spinner
     *
     * @see http://materializecss.com/preloader.html
     */
    public $flashColors = false;

    /**
     * @var array the colors alternating when $flashColors equals 'true'
     */
    private $colors = [
        'blue',
        'red',
        'yellow',
        'green',
    ];

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, ['widget' => 'preloader-wrapper active']);
        Html::addCssClass($this->spinnerOptions, ['spinner' => 'spinner-layer']);
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
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
     * @return string
     */
    private function renderSpinner()
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
