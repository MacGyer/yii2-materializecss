<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\assets\MaterializePluginAsset;
use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the [\yii\base\Widget::begin()](http://www.yiiframework.com/doc-2.0/yii-base-widget.html#begin()-detail)
 * and [\yii\base\Widget::end()](http://www.yiiframework.com/doc-2.0/yii-base-widget.html#end()-detail) calls of NavBar
 * is treated as the content of the navbar. You may use widgets such as [[Nav|Nav]]
 * or [\yii\widgets\Menu](http://www.yiiframework.com/doc-2.0/yii-widgets-menu.html) to build up such content. For example,
 *
 * ```php
 * use macgyer\yii2materializecss\widgets\NavBar;
 * use macgyer\yii2materializecss\widgets\Nav;
 *
 * NavBar::begin(['brandLabel' => 'NavBar Test']);
 * echo Nav::widget([
 *     'items' => [
 *         ['label' => 'Home', 'url' => ['/site/index']],
 *         ['label' => 'About', 'url' => ['/site/about']],
 *     ],
 * ]);
 * NavBar::end();
 * ```
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @see http://materializecss.com/navbar.html
 */
class NavBar extends BaseWidget
{
    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var string|boolean the text of the brand or false if it's not used. Note that this is not HTML-encoded.
     * @see http://materializecss.com/navbar.html
     */
    public $brandLabel = false;

    /**
     * @var boolean the text of the brand or false if it's not used. Note that this is not HTML-encoded.
     * @see http://materializecss.com/navbar.html
     */
    public $fixed = false;

    /**
     * @var array|string|boolean $url the URL for the brand's hyperlink tag. This parameter will be processed by
     * [\yii\helpers\Url::to()](http://www.yiiframework.com/doc-2.0/yii-helpers-baseurl.html#to()-detail)
     * and will be used for the "href" attribute of the brand link. Default value is false that means
     * [\yii\web\Application::homeUrl](http://www.yiiframework.com/doc-2.0/yii-web-application.html#$homeUrl-detail) will be used.
     * You may set it to `null` if you want to have no link at all.
     */
    public $brandUrl = false;

    /**
     * @var array the HTML attributes of the brand link.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
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
    public $fixedContainerOptions = [];

    /**
     * @var array the HTML attributes of the inner container.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var array the HTML attributes of the navigation wrapper container.
     * @see [\yii\helpers\Html::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on how attributes are being rendered.
     */
    public $wrapperOptions = [];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = false;
        $html = [];

        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }

        if ($this->fixed) {
            Html::addCssClass($this->fixedContainerOptions, 'navbar-fixed');
            $html[] = Html::beginTag('div', $this->fixedContainerOptions);
        }

        $html[] = Html::beginTag('nav', $this->options);

        Html::addCssClass($this->wrapperOptions, 'nav-wrapper');
        $html[] = Html::beginTag('div', $this->wrapperOptions);

        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'brand-logo']);
            $html[] = Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        }

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = "{$this->id}-collapse";
        }
        $html[] = $this->renderToggleButton();
        $html[] = Html::beginTag('div', $this->containerOptions);

        echo implode("\n", $html);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $html = [];
        $html[] = Html::endTag('div'); // container

        $html[] = Html::endTag('div'); // nav-wrapper

        $html[] = Html::endTag('nav');

        if ($this->fixed) {
            $html[] = Html::endTag('div');
        }

        MaterializePluginAsset::register($this->getView());

        return implode("\n", $html);
    }

    /**
     * Renders collapsible toggle button.
     * @return string the rendered toggle button.
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
     * Registers the JS for the toggle button.
     * @param string $targetId the ID of the toggled navigation.
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