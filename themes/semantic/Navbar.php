<?php
/**
 * Created by PhpStorm.
 * User: KozminVA
 * Date: 02.10.2015
 * Time: 17:23
 */

namespace app\themes\semantic;

use yii\base\Widget;
use yii\helpers\Html;

/*

    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="active item">Home</a>
        <a class="item">Work</a>
        <a class="item">Company</a>
        <a class="item">Careers</a>
        <div class="right item">
          <a class="ui inverted button">Log in</a>
          <a class="ui inverted button">Sign Up</a>
        </div>
      </div>
    </div>

*/
class Navbar  extends Widget {
    public $options = [];
    public $html = '';

    /**
     * Initializes the widget.
     */
    public function init($html = '') {
        $this->html = $html;
        if( !isset($this->options['class']) ) {
            $this->options['class'] = 'ui container';
        }
        echo Html::beginTag('div', $this->options);
    }

    /**
     * Renders the widget.
     */
    public function run() {
        echo $this->html;
        echo Html::endTag('div');
    }
}