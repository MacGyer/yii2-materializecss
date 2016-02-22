<?php

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\Html;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class Breadcrumbs
 * @package macgyer\yii2materializecss\widgets
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @var string the wrapper for the breadcrumbs list
     * defaults to "div"
     */
    public $tag = 'div';

    /**
     * @var array the HTML options for the wrapper tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options;

    /**
     * @var array the HTML options for the surrounding "nav" tag
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $containerOptions = [];

    /**
     * @var boolean whether to HTML-encode the link labels.
     */
    public $encodeLabels = true;

    /**
     * @var array the first hyperlink in the breadcrumbs (called home link).
     * Please refer to [[links]] on the format of the link.
     * If this property is not set, it will default to a link pointing to [[\yii\web\Application::homeUrl]]
     * with the label 'Home'. If this property is false, the home link will not be rendered.
     */
    public $homeLink;

    /**
     * @var array list of links to appear in the breadcrumbs. If this property is empty,
     * the widget will not render anything. Each array element represents a single link in the breadcrumbs
     * with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional, will be processed by Url::to()
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     * If a link is active, you only need to specify its "label", and instead of writing `['label' => $label]`,
     * you may simply use `$label`.
     *
     * Since version 2.0.1, any additional array elements for each link will be treated as the HTML attributes
     * for the hyperlink tag. For example, the following link specification will generate a hyperlink
     * with CSS class `external`:
     *
     * ```php
     * [
     *     'label' => 'demo',
     *     'url' => 'http://example.com',
     *     'class' => 'external',
     * ]
     * ```
     *
     * Since version 2.0.3 each individual link can override global [[encodeLabels]] param like the following:
     *
     * ```php
     * [
     *     'label' => '<strong>Hello!</strong>',
     *     'encode' => false,
     * ]
     * ```
     *
     */
    public $links = [];

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
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        if (!isset($this->containerOptions['class'])) {
            Html::addCssClass($this->containerOptions, ['breadcrumbsContainer' => 'breadcrumbs']);
        }
        echo Html::beginTag('nav', $this->containerOptions);

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

        if (!isset($this->options['class'])) {
            Html::addCssClass($this->options, ['wrapper' => 'nav-wrapper']);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);

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
}
