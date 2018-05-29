<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * MaterializeAsset provides the required Materialize CSS files.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package assets
 */
class MaterializeAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/materialize/dist';

    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        'css/materialize.min.css'
    ];

    /**
     * @var array list of bundle class names that this bundle depends on.
     */
    public $depends = [
        MaterializeFontAsset::class,
    ];
}
