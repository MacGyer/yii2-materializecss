<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\lib;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use Yii;
use yii\helpers\Json;
use yii\web\View;

/**
 * MaterializeWidgetTrait provides the basics for all Materialize widgets features.
 *
 * Please note: a class using this trait must declare a public field named `options` with the array default value:
 *
 * ```php
 * class MyWidget extends \yii\base\Widget
 * {
 *     use MaterializeWidgetTrait;
 *
 *     public $options = [];
 * }
 * ```
 *
 * This field is not present in the trait in order to avoid possible PHP Fatal error on definition conflict.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package lib
 */
trait MaterializeWidgetTrait
{
    /**
     * @var array the options for the underlying Materialize JS plugin.
     * Please refer to the corresponding Materialize documentation web page.
     *
     * @see http://materializecss.com/
     */
    public $clientOptions = [];

    /**
     * @var array the event handlers for the underlying Materialize JS plugin.
     * Please refer to the corresponding Materialize documentation web page.
     *
     * @see http://materializecss.com/
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     * This method will register the MaterializeAsset bundle. When overriding this method,
     * make sure to call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Registers a specific Materialize plugin and the related events.
     * @param string $name the name of the Materialize plugin
     * @param string|null $selector the name of the selector the plugin shall be attached to
     * @uses [yii\helper\BaseJson::encode()](http://www.yiiframework.com/doc-2.0/yii-helpers-basejson.html#encode()-detail)
     * to encode the [[clientOptions]]
     * @uses [[MaterializePluginAsset::register()]]
     * @uses [[registerClientEvents()]]
     */
    protected function registerPlugin($name, $selector = null)
    {
        /** @var View $view */
        $view = $this->getView();

        MaterializePluginAsset::register($view);

        $id = $this->options['id'];

        if (is_null($selector)) {
            $selector = '#' . $id;
        }

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);

            $js = "document.addEventListener('DOMContentLoaded', function() {M.$name.init(document.querySelectorAll('$selector'), $options);});";
            $view->registerJs($js, View::POS_END);
        }

        $this->registerClientEvents();
    }

    /**
     * Registers JS event handlers that are listed in [[clientEvents]].
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            /** @var View $view */
            $view = $this->getView();
            $id = $this->options['id'];
            $js[] = "var elem_$id = document.getElementById('$id');";
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "elem_$id.addEventListener('$event', $handler);";
            }
            $view->registerJs(implode("\n", $js), View::POS_END);
        }
    }

    /**
     * @return string
     */
    protected function getUniqueId($prefix = 'u_')
    {
        $uniqid = sha1(uniqid($prefix, true));
        return "{$prefix}{$uniqid}";
    }
}
