<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 3/7/19
 * Time: 1:18 PM
 */

namespace api\controllers;


use yii\base\BaseObject;
use yii\di\Instance;
use yii\rest\Controller;
use Yii;

class Bar
{
    public $title = 'bar1';
}

class Foo
{
    public $bar;

    public function pr()
    {
        echo $this->bar->title;
    }

}


class DepencyInjectionController extends Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    public function actionTest()
    {
        Yii::$container->set('Foo', function ($container, $params, $config) {
            $foo = new Foo();
            $foo->bar = new Bar();
            return $foo;
        });
        $foo = Yii::$container->get('Foo', ['come']);
        echo $foo->pr();
    }
}