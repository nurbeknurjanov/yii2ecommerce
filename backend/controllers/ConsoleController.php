<?php
namespace backend\controllers;

use user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ConsoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['run'],
                        'allow' => true,
                        //'roles' => [User::ROLE_MANAGER],// if you set it some role
                        //only that roles or higher can access
                        // set there is no roles, it means anyone, even guests can reach this action
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMINISTRATOR],// if you set it some role
                    ],
                ],
            ],
        ];
    }

    public function actionRun($controller, $action='index')
    {
        /*$controllerName = ucfirst($controller).'Controller';
        $controllerName = "\\console\\controllers\\".$controllerName;
        $consoleController = new $controllerName($controller, Yii::$app, []);*/

        Yii::$app->controllerNamespace = 'console\\controllers';
        $consoleController = Yii::$app->createControllerByID($controller);
        return $consoleController->runAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
