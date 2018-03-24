<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\grid;

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\Icon;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * ActionColumn is a column for the [[GridView|GridView]] widget that displays buttons for viewing and manipulating the items.
 *
 * To add an ActionColumn to the grid view, add it to the `$columns` (inherited from [yii\grid\GridView](http://www.yiiframework.com/doc-2.0/yii-grid-gridview.html#$columns-detail))
 * configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => ActionColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage grid
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Initializes the action column and triggers rendering of default buttons.
     * See [[initDefaultButtons]] for details.
     */
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    /**
     * Initializes the default button rendering callbacks.
     * This method uses [[Icon|Icon]] to display iconic buttons.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                ], $this->buttonOptions);
                return Html::a(Icon::widget([
                    'name' => 'visibility',
                ]), $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                ], $this->buttonOptions);
                return Html::a(Icon::widget([
                    'name' => 'edit',
                ]), $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ], $this->buttonOptions);
                return Html::a(Icon::widget([
                    'name' => 'delete',
                ]), $url, $options);
            };
        }
    }
}
