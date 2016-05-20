<?php

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * MaterializeFontAsset provides the Material Icons font family CSS.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
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
