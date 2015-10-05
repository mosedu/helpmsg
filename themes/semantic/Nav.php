<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 05.10.2015
 * Time: 14:39
 */

namespace app\themes\semantic;

use yii;
use yii\helpers\Html;
use yii\base\Widget;


class Nav extends Widget {
    public $tag = 'div';
    public $options = ['class' => 'ui secondary pointing menu'];
    public $html = '';

    public $route;

    public $items = [];
    public $itemTag = 'a';
    public $itemOptions = ['class' => 'item'];
    public $activeClass = 'active';
    public $activateItems = true;

    /**
     * Initializes the widget.
     */
    public function init($html = '') {
        $this->html = $html;
        if( !isset($this->options['class']) ) {
            $this->options['class'] = 'ui secondary pointing menu';
        }
        echo Html::beginTag($this->tag, $this->options);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo $this->html;
        foreach($this->items As $v) {
            if (isset($v['visible']) && !$v['visible']) {
                continue;
            }
            if (is_string($v)) {
                return $v;
            }
            $tag = isset($v['tag']) ? $v['tag'] : $this->itemTag;
            $label = isset($v['label']) ? $v['label'] : '';
            $opt = isset($v['options']) ? $v['options'] : $this->itemOptions;
            if( $tag == 'a' ) {
                if( isset($v['url']) ) {
                    $opt['href'] = $v['url'];
                }
            }

            $active = $this->isItemActive($v);

            if ($this->activateItems && $active) {
                Html::addCssClass($opt, $this->activeClass);
            }
            echo Html::tag($tag, $label, $opt);
        }
        echo Html::endTag('div');
    }

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}