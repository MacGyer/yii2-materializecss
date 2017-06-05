<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * The JS plugin noUiSlider adds useful functionality for slider (i. e. range) input elements.
 *
 * @see http://materializecss.com/forms.html#range
 * @see https://refreshless.com/nouislider/
 * @package assets
 */
class NoUiSliderAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/materialize/extras/noUiSlider';

    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = ['nouislider.css'];

    /**
     * @var array list of JS files that this bundle contains.
     */
    public $js = ['nouislider.min.js'];
}
