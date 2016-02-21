<?php

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * Class MaterializeAsset
 * @package macgyer\yii2materializecss\assets
 */
class MaterializeAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';

    public $css = [
        'css/materialize.min.css'
    ];

    public $depends = [
        'macgyer\yii2materializecss\assets\MaterializeFontAsset'
    ];
}
