<?php
namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use yii\helpers\Html;

/**
 * Description of Preloader
 *
 * @author marco
 */
class Preloader extends BaseWidget
{
    public $options = [];
    
    public $spinnerOptions = [];
    
    public $active = true;
    
    public $spinnerColor = 'spinner-blue-only';

    public function run()
    {
        Html::addCssClass($this->options, 'preloader-wrapper');
        if ($this->active) {
            Html::addCssClass($this->options, 'active');
        }
        echo Html::beginTag('div', $this->options);
        
        Html::addCssClass($this->spinnerOptions, 'spinner-layer');
        Html::addCssClass($this->spinnerOptions, $this->spinnerColor);
        echo Html::beginTag('div', $this->spinnerOptions);
        
        echo Html::beginTag('div', ['class' => 'circle-clipper left']);
        echo Html::tag('div', '', ['class' => 'circle']);
        echo Html::endTag('div'); // circle-clipper
        echo Html::beginTag('div', ['class' => 'gap-patch']);
        echo Html::tag('div', '', ['class' => 'circle']);
        echo Html::endTag('div'); // gap
        echo Html::beginTag('div', ['class' => 'circle-clipper right']);
        echo Html::tag('div', '', ['class' => 'circle']);
        echo Html::endTag('div'); // circle-clipper
        echo Html::endTag('div'); // spinner-layer
        echo Html::endTag('div'); // preload-wrapper
        
        parent::run();
    }
}