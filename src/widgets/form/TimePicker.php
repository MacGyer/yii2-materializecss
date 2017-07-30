<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets\form;

use macgyer\yii2materializecss\lib\BaseInputWidget;
use macgyer\yii2materializecss\lib\Html;

/**
 * TimePicker renders a time picker input element.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 * @subpackage form
 * @see http://materializecss.com/forms.html#time-picker
 */
class TimePicker extends BaseInputWidget
{
    /**
     * @var boolean whether time format is 12 or 24 hour.
     */
    public $isTwelveHourFormat = false;

    /**
     * @var string the label for the "select time" button.
     */
    public $okLabel = 'OK';

    /**
     * @var string the label for the "clear time" button.
     */
    public $clearLabel = 'Clear';

    /**
     * @var string the label for the "cancel time selection" button.
     */
    public $cancelLabel = 'Cancel';

    /**
     * @var string the default time displayed when picker is opened.
     *
     * Examples: `'now'`, `'1:55PM'`, `'18:30'`
     */
    public $defaultValue = 'now';

    /**
     * Initialize the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->clientOptions['donetext'])) {
            $this->clientOptions['donetext'] = $this->okLabel;
        }

        if (!isset($this->clientOptions['cleartext'])) {
            $this->clientOptions['cleartext'] = $this->clearLabel;
        }

        if (!isset($this->clientOptions['canceltext'])) {
            $this->clientOptions['canceltext'] = $this->cancelLabel;
        }

        if (isset($this->defaultValue)) {
            $this->clientOptions['default'] = $this->defaultValue;
        }

        $this->clientOptions['twelvehour'] = $this->isTwelveHourFormat;
    }

    /**
     * Execute the widget.
     * @return string the result of widget execution to be outputted
     */
    public function run()
    {
        Html::addCssClass($this->options, 'timepicker');

        $this->registerPlugin('pickatime');

        if ($this->hasModel()) {
            $this->options['data-value'] = isset($this->value) ? $this->value : Html::getAttributeValue($this->model, $this->attribute);
            return Html::activeInput('text', $this->model, $this->attribute, $this->options);
        } else {
            $this->options['data-value'] = $this->value;
            return Html::input('text', $this->name, $this->value, $this->options);
        }
    }
}
