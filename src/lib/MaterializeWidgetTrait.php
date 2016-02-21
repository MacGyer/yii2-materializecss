<?php

namespace macgyer\yii2materializecss\lib;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use Yii;
use yii\helpers\Json;

/**
 * Trait MaterializeWidgetTrait
 * @package macgyer\yii2materializecss\lib
 */
trait MaterializeWidgetTrait
{
    public $clientOptions = [];
    public $clientEvents = [];

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @param $name
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        MaterializePluginAsset::register($view);

        $id = $this->options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }

    /**
     * register the event handlers
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            $id = $this->options['id'];
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}