<?php

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Button
 * @package macgyer\yii2materializecss\widgets
 */
class Button extends BaseWidget
{
    public $tagName = 'button';
    public $label = 'Button';
    public $encodeLabel = true;
    public $icon;

    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        Html::addCssClass($this->options, ['widget' => 'btn']);
    }

    /**
     * @return string
     */
    public function run()
    {
        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        $content = $this->renderIcon() . $label;

        return Html::tag($this->tagName, $content, $this->options);
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    private function renderIcon()
    {
        if (!$this->icon) {
            return '';
        }

        $iconName = ArrayHelper::getValue($this->icon, 'name', null);
        $iconPosition = ArrayHelper::getValue($this->icon, 'position', null);
        $iconOptions = ArrayHelper::getValue($this->icon, 'options', null);

        if (!$iconName) {
            throw new InvalidConfigException('The icon name must be specified.');
        }

        Html::addCssClass($iconOptions, ['material-icons', $iconPosition]);

        return Html::tag('i', $iconName, $iconOptions);
    }
}
