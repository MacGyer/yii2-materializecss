<?php
/**
 * @link https://github.com/MacGyer/yii2-materializecss
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-materializecss/blob/master/LICENSE
 */

namespace macgyer\yii2materializecss\widgets;

use macgyer\yii2materializecss\lib\BaseWidget;
use macgyer\yii2materializecss\lib\Html;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Alert renders Yii's session flash messages.
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 */
class Alert extends BaseWidget
{
    /**
     * @var array the default alert levels.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the alert type (will be uses as CSS class)
     */
    private $predefinedAlertLevels = [
        'error'   => 'error',
        'danger'  => 'danger',
        'success' => 'success',
        'info'    => 'info',
        'warning' => 'warning'
    ];

    /**
     * @var array use this property to define own alert levels and their corresponding CSS classes or to overrride the
     * default levels.
     * @see [[$predefinedAlertLevels]]
     */
    public $alertLevels = [];
    /**
     * @var array
     */
    public $options = [];

    /**
     * initialize the widget
     */
    public function init()
    {
        parent::init();

        $this->alertLevels = ArrayHelper::merge($this->predefinedAlertLevels, $this->alertLevels);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $flashes = Yii::$app->session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data) {
            if (isset($this->alertLevels[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = 'alert ' . $this->alertLevels[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                    echo $this->renderHtml($message, $this->options);
                }

                Yii::$app->session->removeFlash($type);
            }
        }
    }

    /**
     * @param $message
     * @param array $options
     * @return string
     */
    private function renderHtml($message, $options = [])
    {
        $html = Html::beginTag('div', $options);
        $html .= '<div class="card-panel">';
        $html .= $message;
        $html .= '</div>';
        $html .= Html::endTag('div');

        return $html;
    }
}
