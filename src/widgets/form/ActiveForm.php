<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

/**
 * ActiveForm is a widget that builds an interactive HTML form for one or multiple data models.
 * @see http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html#$fieldConfig-detail
     */
    public $fieldClass = ActiveField::class;

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
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (!isset($this->options['data-success-class'])) {
            $this->options['data-success-class'] = $this->successCssClass;
        }

        if (!isset($this->options['data-error-class'])) {
            $this->options['data-error-class'] = $this->errorCssClass;
        }

        if ($this->enableClientValidation) {
            $this->registerAfterValidateHandler();
        }

        parent::init();
    }

    /**
     * Generates a form field.
     * @param \yii\base\Model $model the data model.
     * @param string $attribute the attribute name or expression. See [yii\helpers\Html::getAttributeName()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#getAttributeName()-detail) for the format about attribute expression.
     * @param array $options the additional configurations for the field object. These are properties of [yii\widgets\ActiveField](http://www.yiiframework.com/doc-2.0/yii-widgets-activefield.html) or a subclass, depending on the value of [$fieldClass](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html#$fieldClass-detail).
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }

    /**
     * Register the necessary JS handlers to set error messages and validation state indicators.
     */
    protected function registerAfterValidateHandler()
    {
        $view = $this->getView();
        $id = $this->options['id'];

        $view->registerJs(<<<JS
$('#{$id}').on('afterValidateAttribute', function (evt, attribute, messages) {
    var yiiForm = $(this);
    $(attribute.container + ' ' + attribute.error).attr('data-error', messages[0]);
    messages[0] ? $(attribute.input).addClass(yiiForm.attr('data-error-class')).removeClass(yiiForm.attr('data-success-class')) : $(attribute.input).addClass(yiiForm.attr('data-success-class')).removeClass(yiiForm.attr('data-error-class'));
});
JS
        );
    }
}
