<?php

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * DatePicker renders a clock picker input element.
 *
 * This bundle implements Ching Yaw Hao's clock picker plugin.
 *
 * @see https://github.com/chingyawhao/materialize-clockpicker
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class TimePickerAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@vendor/macgyer/yii2-materializecss/src/assets/dist/materialize-clockpicker';

    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        'materialize.clockpicker.css'
    ];

    /**
     * @var array list of JS files that this bundle contains.
     */
    public $js = [
        'materialize.clockpicker.js'
    ];

    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        'macgyer\yii2materializecss\assets\MaterializeFontAsset',
    ];
}
