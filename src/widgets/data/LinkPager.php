<?php

namespace macgyer\yii2materializecss\widgets\data;

/**
 * Class LinkPager
 * @package macgyer\yii2materializecss\widgets\data
 */
class LinkPager extends yii\widgets\LinkPager
{
    /**
     * @var string|bool the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '<i class="material-icons">chevron_right</i>';

    /**
     * @var string|bool the label for the "previous" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '<i class="material-icons">chevron_left</i>';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
    }
}
