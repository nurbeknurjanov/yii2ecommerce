<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 3/7/19
 * Time: 1:18 PM
 */

namespace api\controllers;


use yii\base\BaseObject;
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

class Maa
{
    public function __construct()
    {
/*        echo '<pre>';
        print_r($some);
        echo '</pre>';
        die();*/
    }

    public $mar='mar';
    public function pr()
    {
        echo $this->mar;
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
        //works if extends from baseObject
        /*$foo = new Foo(['bar'=>new Bar()]);
        */


        /*Yii::$container->set(Foo::class, [
            'bar'=>new Bar,
        ]);
        $foo = Yii::$container->get(Foo::class);*/
        //$foo = Yii::$container->get(Foo::class, [], ['bar'=>new Bar()]);
        Yii::$container->setDefinitions([
            'm'=>[
                [
                    'class'=>Maa::class,
                    'mar'=>'no',
                ],
                ['/var/tempfiles']
            ],
            /*'m' => [
                'class'=>Maa::class,
                //['some'],
                //'mar'=>'no mar',
                //'bar'=>Yii::$container->get(Bar::class),
            ]*/
        ]);
        /*Yii::$container->setDefinitions([
            Foo::class => Maa::class
        ]);*/
        $foo = Yii::$container->get('m');
        $foo->pr();
        /*$foo = Yii::$container->get(Foo::class, [], ['bar'=>new Bar()]);
        $foo->pr();
        die();*/
    }
}