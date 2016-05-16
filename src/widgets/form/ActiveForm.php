<?php

namespace macgyer\yii2materializecss\widgets\form;

/**
 * Class ActiveForm
 * @package macgyer\yii2materializecss\widgets\form
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'macgyer\yii2materializecss\widgets\form\ActiveField';

    /**
     * @var string the CSS class that is added to a field container when the associated attribute has validation error.
     */
    public $errorCssClass = 'invalid';

    /**
     * @var string the CSS class that is added to a field container when the associated attribute is successfully validated.
     */
    public $successCssClass = 'valid';

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}
