<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\data;

/**
 * DetailView displays the detail of a single data model.
 *
 * This data model is represented by `$model` (inherited from [yii\widgets\DetailView](http://www.yiiframework.com/doc-2.0/yii-widgets-detailview.html)).
 *
 * DetailView is best used for displaying a model in a regular format (e.g. each model attribute
 * is displayed as a row in a table.) The model can be either an instance of [yii\base\Model](http://www.yiiframework.com/doc-2.0/yii-base-model.html)
 * or an associative array.
 *
 * DetailView uses the `$attributes` property (inherited from [yii\widgets\DetailView](http://www.yiiframework.com/doc-2.0/yii-widgets-detailview.html))
 * to determine which model attributes should be displayed and how they should be formatted.
 *
 * A typical usage of DetailView is as follows:
 *
 * ```php
 * echo DetailView::widget([
 *     'model' => $model,
 *     'attributes' => [
 *         'title',               // title attribute (in plain text)
 *         'description:html',    // description attribute in HTML
 *         [                      // the owner name of the model
 *             'label' => 'Owner',
 *             'value' => $model->owner->name,
 *         ],
 *         'created_at:datetime', // creation date formatted as datetime
 *     ],
 * ]);
 * ```
 *
 * @see [yii\widgets\DetailView](http://www.yiiframework.com/doc-2.0/yii-widgets-detailview.html)
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage data
 */
class DetailView extends \yii\widgets\DetailView
{
    /**
     * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
     * what container tag should be used. It defaults to "table" if not set.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on
     * how attributes are being rendered.
     */
    public $options = ['class' => 'table striped bordered detail-view'];
}
