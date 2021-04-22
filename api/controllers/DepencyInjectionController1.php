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

class Foo extends BaseObject
{
    public $prop='default';
    public $bar;
    /*public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }*/
    public function __construct($bar)
    {
        parent::__construct($bar);
    }
/*    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        $this->init();
    }*/
    public function pr()
    {
        echo $this->bar->title;
    }

}
class Foo1
{
    public $bar;
    public function pr()
    {
        echo $this->bar->title;
    }
    public function doSomething($param1, Bar $bar)
    {
        $this->bar = $bar;
        echo $param1.'=>';
        $this->pr();
        // Работаем с $something
    }
}


class DepencyInjectionController extends Controller
{

    public function actionTest()
    {
        /*$bar = new Bar();
        echo $bar->title;*/
        $foo = Yii::$container->get(Foo::class, ['constructParam1'], ['prop'=>'123']);
        echo $foo->prop."---<br>";
        //echo $foo->pr();
        /*$obj = new Foo1();
        Yii::$container->invoke([$obj, 'doSomething'], ['param1' => 42]);*/
        die();
        Yii::$container->set()
    }
}