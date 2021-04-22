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
    public $title = 'bar';
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
        Yii::$container->setDefinitions([
            Foo::class=>[
                //'bar'=> Instance::of(Bar::class),
                'bar'=> Yii::$container->get(Bar::class,[],['title'=>'another',])
            ],
        ]);
        $foo = Yii::$container->get(Foo::class);
        echo $foo->pr();
    }
}