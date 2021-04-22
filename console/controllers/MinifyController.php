<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use user\models\User;
use user\models\Token;
use Yii;
use yii\base\Exception;
use MatthiasMullie\Minify;

class MinifyController extends Controller
{
    public $js_file;
    public $js_output_file;
    public $css_file;
    public $css_output_file;
    public function options($actionID)
    {
        $options = parent::options($actionID);
        $options[] = 'js_file';
        $options[] = 'js_output_file';
        $options[] = 'css_file';
        $options[] = 'css_output_file';
        return $options;
    }

    public function actionIndex()
    {
        $minifier = new Minify\CSS($this->css_file);
        $minifier->minify($this->css_output_file);

        $minifier = new Minify\JS($this->js_file);
        $minifier->minify($this->js_output_file);
    }

    public function actionAll()
    {
        $dir = Yii::getAlias('@app').'/..';//console dir
        shell_exec("php $dir/yii asset $dir/themes/sakura/assets.php          $dir/frontend/config/assets/assets-sakura.php");
        shell_exec("php $dir/yii asset $dir/themes/sakura_light/assets.php    $dir/frontend/config/assets/assets-sakura-light.php");
        shell_exec("php $dir/yii asset $dir/themes/bootstrap/assets.php       $dir/frontend/config/assets/assets-bootstrap.php");
        //php yii asset themes/landing/assets.php         landing/config/assets-landing.php
    }
}