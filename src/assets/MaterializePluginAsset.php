<?php

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * Class MaterializePluginAsset
 * @package medienpol\yii2materialize
 */
class MaterializePluginAsset extends AssetBundle
{
    public $sourcePath = '@bower/materialize/dist';

    public $js = [
        'js/materialize.min.js'
    ];
}
