<?php

/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... Leonardo J. Caballero G.
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\assets;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the [pickadate.js library](http://amsul.ca/pickadate.js)
 *
 * @author Leonardo J. Caballero G. <leonardocaballero@gmail.com>
 */
class PickadateAsset extends AssetBundle
{
    public $sourcePath = '@bower/pickadate/lib';
    public $js = [
        'picker.time.js',
    ];
}
