<?php

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\lib\MaterializeWidgetTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class NavBar
 * @package macgyer\yii2materializecss\widgets
 */
class NavBar extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var string|boolean the text of the brand or false if it's not used. Note that this is not HTML-encoded.
     * @see http://materializecss.com/navbar.html
     */
    public $brandLabel = false;

    /**
     * @var array|string|boolean $url the URL for the brand's hyperlink tag. This parameter will be processed by [[\yii\helpers\Url::to()]]
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [[\yii\web\Application::homeUrl]] will be used.
     * You may set it to `null` if you want to have no link at all.
     */
    public $brandUrl = false;

    /**
     * @var array the HTML attributes of the brand link.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $brandOptions = [];

    /**
     * @var string text to show for screen readers for the button to toggle the navbar.
     */
    public $screenReaderToggleText = 'Toggle navigation';

    /**
     * @var boolean whether the navbar content should be included in an inner div container which by default
     * adds left and right padding. Set this to false for a 100% width navbar.
     */
    public $renderInnerContainer = true;

    /**
     * @var array the HTML attributes of the inner container.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $innerContainerOptions = [];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = [];

        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, ['navbar', 'navbar-default']);
        } else {
            Html::addCssClass($this->options, ['widget' => 'navbar']);
        }

        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        echo Html::beginTag($tag, $options);

        echo Html::beginTag('nav');

        echo Html::beginTag('div', ['class' => 'nav-wrapper']);

        if ($this->renderInnerContainer) {
            if (!isset($this->innerContainerOptions['class'])) {
                Html::addCssClass($this->innerContainerOptions, 'container');
            }
            echo Html::beginTag('div', $this->innerContainerOptions);
        }

        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'brand-logo']);
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        }

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = "{$this->options['id']}-collapse";
        }
        echo $this->renderToggleButton();

//        Html::addCssClass($this->containerOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::beginTag($tag, $options);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        echo Html::endTag($tag);
        if ($this->renderInnerContainer) {
            echo Html::endTag('div');
        }

        echo Html::endTag('div');

        echo Html::endTag('nav');

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        echo Html::endTag($tag);

        MaterializePluginAsset::register($this->getView());
    }

    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        $toggleTarget = 'sidenav_' . md5(uniqid());

        $this->registerToggleButtonScript($toggleTarget);

        return Html::a('<i class="material-icons">menu</i>', '#', [
            'data-activates' => $toggleTarget,
            'class' => 'button-collapse'
        ]);
    }

    /**
     * @param $targetId
     */
    protected function registerToggleButtonScript($targetId)
    {
        $view = $this->getView();
        MaterializePluginAsset::register($view);

        $selector = '#' . $this->options['id'] . ' .button-collapse';

        $js = "var sideNav = jQuery('#{$this->containerOptions['id']} > ul').clone();";
        $js .= "sideNav.removeClass().addClass('side-nav').attr('id', '{$targetId}').appendTo('body');";
        $js .= "jQuery('{$selector}').sideNav();";
        $view->registerJs($js);
    }
}
