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
 * All flash messages are displayed in the sequence they were assigned using
 * [yii\web\Session::setFlash()](http://www.yiiframework.com/doc-2.0/yii-web-session.html#setFlash()-detail).
 *
 * You can set messages as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages can be set by specifying an array:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Christoph Erdmann <yii2-materializecss@pluspunkt-coding.de>
 * @package widgets
 */
class Alert extends BaseWidget
{
    /**
     * @var array the default alert levels.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the alert type (will be uses as CSS class)
     *
     * To define own alert levels and their corresponding CSS classes or to overrride the
     * default levels use [[alertLevels]]
     */
    protected $predefinedAlertLevels = [
        'error'   => 'error',
        'danger'  => 'danger',
        'success' => 'success',
        'info'    => 'info',
        'warning' => 'warning',
        'default' => 'default',
    ];

    /**
     * @var array custom alert levels
     */
    public $alertLevels = [];

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see [yii\helpers\BaseHtml::renderTagAttributes()](http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html#renderTagAttributes()-detail) for details on
     * how attributes are being rendered.
     */
    public $options = [];

    /**
     * Initializes the widget.
     *
     * @uses [yii\helper\BaseArrayHelper::merge()](http://www.yiiframework.com/doc-2.0/yii-helpers-basearrayhelper.html#merge()-detail)
     */
    public function init()
    {
        parent::init();

        $this->alertLevels = ArrayHelper::merge($this->predefinedAlertLevels, $this->alertLevels);
    }

    /**
     * Executes the widget.
     *
     * @uses [yii\web\Session](http://www.yiiframework.com/doc-2.0/yii-web-session.html)
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
     * Renders a single flash message.
     * @param string $message the content of the message
     * @param array $options the HTML attributes for the container tag
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
