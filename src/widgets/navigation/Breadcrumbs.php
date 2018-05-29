<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\navigation;

use macgyer\yii2materializecss\lib\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Breadcrumbs displays a list of links indicating the position of the current page in the whole site hierarchy.
 *
 * For example, breadcrumbs like "Home / Sample Post / Edit" means the user is viewing an edit page
 * for the "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home"
 * to return to the homepage.
 *
 * To use Breadcrumbs, you need to configure its `$links` property (inherited from
 * [yii\widgets\Breadcrumbs](http://www.yiiframework.com/doc-2.0/yii-widgets-breadcrumbs.html)) , which specifies the links to be
 * displayed.
 *
 * For example,
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget([
 *     'itemTemplate' => "<i>{link}</i>\n", // template for all links
 *     'links' => [
 *         [
 *             'label' => 'Post Category',
 *             'url' => ['post-category/view', 'id' => 10],
 *             'template' => "<b>{link}</b>\n", // template for this link only
 *         ],
 *         ['label' => 'Sample Post', 'url' => ['post/edit', 'id' => 1]],
 *         'Edit',
 *     ],
 * ]);
 * ```
 *
 * Because breadcrumbs usually appear in nearly every page of a website, you may consider placing it in a layout view.
 * You can use a view parameter (e.g. `$this->params['breadcrumbs']`) to configure the links in different
 * views. In the layout view, you assign this view parameter to the `$links` property like the following:
 *
 * ```php
 * // $this is the view object currently being used
 * echo Breadcrumbs::widget([
 *     'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
 * ]);
 * ```
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage navigation
 * @see https://materializecss.com/breadcrumbs.html
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @var string the name of the wrapper tag for the breadcrumbs list.
     * defaults to "div"
     */
    public $tag = 'div';

    /**
     * @var array the HTML options for the surrounding "nav" tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on
     * how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var array the HTML options for the wrapper tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on
     * how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the HTML options for the inner container tag.
     *
     * Set this to 'false' if you do not want the inner container to be rendered.
     * The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the inner container tag.
     *
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on
     * how attributes are being rendered.
     * @see https://github.com/MacGyer/yii2-materializecss/pull/5
     */
    public $innerContainerOptions = [];

    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each inactive item.
     */
    public $itemTemplate = "{link}\n";

    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}`
     * will be replaced with the actual HTML link for each active item.
     */
    public $activeItemTemplate = "<span class=\"breadcrumb active\">{link}</span>\n";

    /**
     * Initialize the widget.
     */
    public function init()
    {
        if (!isset($this->containerOptions['class'])) {
            Html::addCssClass($this->containerOptions, ['breadcrumbsContainer' => 'breadcrumbs']);
        }

        if (!isset($this->options['class'])) {
            Html::addCssClass($this->options, ['wrapper' => 'nav-wrapper']);
        }

        if ($this->innerContainerOptions !== false && !isset($this->innerContainerOptions['class'])) {
            Html::addCssClass($this->innerContainerOptions, ['innerContainer' => 'col s12']);
        }
    }

    /**
     * Render the widget.
     * @return string the result of widget execution to be outputted.
     * @throws InvalidConfigException
     */
    public function run()
    {
        if (empty($this->links)) {
            return '';
        }

        $html[] = Html::beginTag('nav', $this->containerOptions);
        $html[] = Html::beginTag($this->tag, $this->options);

        if ($this->innerContainerOptions !== false) {
            $innerContainerTag = ArrayHelper::remove($this->innerContainerOptions, 'tag', 'div');
            $html[] = Html::beginTag($innerContainerTag, $this->innerContainerOptions);
        }
        $html[] = implode('', $this->prepareLinks());

        if ($this->innerContainerOptions !== false) {
            $html[] = Html::endTag($innerContainerTag);
        }

        $html[] = Html::endTag($this->tag);
        $html[] = Html::endTag('nav');

        return implode("\n", $html);
    }

    /**
     * Renders a single breadcrumb item.
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the link.
     * @return string the rendering result
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            Html::addCssClass($options, ['link' => 'breadcrumb']);

            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }

    /**
     * Generates all breadcrumb links and sets active states.
     * @return array all processed items
     * @uses [[renderItem]]
     * @throws InvalidConfigException
     */
    protected function prepareLinks()
    {
        $links = [];
        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        return $links;
    }
}
