<?php

namespace macgyer\yii2materializecss\widgets\data;

/**
 * Class DetailView
 * @package macgyer\yii2materializecss\widgets\data
 */
class DetailView extends \yii\widgets\DetailView
{
    /**
     * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
     * what container tag should be used. It defaults to "table" if not set.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'table striped bordered detail-view'];
}
