<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * MaterializeFontAsset provides the Material Icons font family CSS.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package assets
 */
class MaterializeFontAsset extends AssetBundle
{
    /**
     * @var array list of CSS files that this bundle contains.
     */
    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons'
    ];
}
