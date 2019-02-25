<?php

namespace extended\setting;

use yii\base\BootstrapInterface;
use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;
use yii\helpers\Url;


class Setting extends Component implements  BootstrapInterface
{
    public function bootstrap($app)
    {
        if(isset($_GET['theme']))
        {
            //if(is_dir(Yii::getAlias('@themes').'/'.$_GET['theme']))
            {
                setcookie("theme", $_GET['theme'], time()+3600*8, '/');
            }
            /*else
                throw new Exception("There is no theme such as '{$_GET['theme']}'");*/

            //just the same page, the same language, the same route, the same get parameters
            $route = Yii::$app->request->resolve()[0];
            $params = Yii::$app->request->resolve()[1];
            unset($params['theme']);
            return Yii::$app->response->redirect(Url::to(["/".$route]+$params));
        }
        /*
        $theme = Yii::$app->request->cookies->getValue('theme');
        if($theme && is_dir(Yii::getAlias('@themes').'/'.$theme)){
            Yii::$app->view->theme->pathMap = [  '@app/views' => "@themes/".$theme ];
            Yii::$app->view->theme->baseUrl = Yii::$app->request->baseUrl.'/themes/'.$theme;
        }
        */
    }

} 