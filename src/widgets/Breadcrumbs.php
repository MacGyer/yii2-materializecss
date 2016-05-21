<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Breadcrumbs
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @var string the wrapper for the breadcrumbs list
     * defaults to "div"
     */
    public $tag = 'div';

    /**
     * @var array the HTML options for the surrounding "nav" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var array the HTML options for the wrapper tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
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
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
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
     * Renders the widget.
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        echo Html::beginTag('nav', $this->containerOptions);
        echo Html::beginTag($this->tag, $this->options);

        if ($this->innerContainerOptions !== false) {
            $innerContainerTag = ArrayHelper::remove($this->innerContainerOptions, 'tag', 'div');
            echo Html::beginTag($innerContainerTag, $this->innerContainerOptions);
        }
        echo implode('', $this->prepareLinks());

        if ($this->innerContainerOptions !== false) {
            echo Html::endTag($innerContainerTag);
        }

        echo Html::endTag($this->tag);
        echo Html::endTag('nav');
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
     * @return array
     * @throws InvalidConfigException
     */
    private function prepareLinks()
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
