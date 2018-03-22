<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * MaterializePluginAsset provides the Materialize JS files.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package assets
 */
class MaterializePluginAsset extends AssetBundle
{
    /**
     * @var string the directory that contains the source asset files for this asset bundle.
     */
    public $sourcePath = '@bower/materialize/dist';

    /**
     * @var array list of JS files that this bundle contains.
     */
    public $js = [
        'js/materialize.min.js'
    ];
}
