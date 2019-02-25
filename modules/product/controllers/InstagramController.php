<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 10/25/16
 * Time: 1:19 AM
 */

namespace product\controllers;


use extended\controller\Controller;
use InstagramAPI\Exception\ChallengeRequiredException;
use InstagramAPI\Response\LoginResponse;
use product\models\Compare;
use product\models\InstagramModel;
use product\models\Product;
use product\models\ProductNetwork;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use product\models\search\ProductSearchFrontend;
use Yii;
use InstagramAPI\Instagram;
use InstagramAPI\Media\Photo\InstagramPhoto;
use InstagramAPI\Media\Photo\PhotoDetails;
use InstagramAPI\Media\Video\VideoDetails;


class InstagramController extends ProductController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['export'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('exportInstagram', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['remove'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('removeInstagram', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateInstagram', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['update-data'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateDataInstagram', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['clean', 'index', 'fix1'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }


    public function actionExport($id)
    {
        $model = $this->findModel($id);
        $response = InstagramModel::create($model);
        ProductNetwork::createOrUpdate($model, ProductNetwork::NETWORK_TYPE_INSTAGRAM, $response->getMedia()->getId(), $response->getMedia()->getCode());
        Yii::$app->session->setFlash('success', 'You have successfully added product to instagram');
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        InstagramModel::remove($model);
        ProductNetwork::remove($model, ProductNetwork::NETWORK_TYPE_INSTAGRAM);
        Yii::$app->session->setFlash('success', 'You have successfully removed product from instagram');
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $response = InstagramModel::update($model);
        ProductNetwork::createOrUpdate($model, ProductNetwork::NETWORK_TYPE_INSTAGRAM, $response->getMedia()->getId(), $response->getMedia()->getCode());
        Yii::$app->session->setFlash('success', 'You have successfully updated product to instagram');
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionUpdateData($id)
    {
        $model = $this->findModel($id);
        $response = InstagramModel::updateData($model);
        ProductNetwork::createOrUpdate($model, ProductNetwork::NETWORK_TYPE_INSTAGRAM, $response->getMedia()->getId(), $response->getMedia()->getCode());
        Yii::$app->session->setFlash('success', 'You have successfully updated product to instagram');
        return $this->redirect(Yii::$app->request->referrer);
    }














    public function actionFix1()
    {
        $username = Yii::$app->params['instagram']['username'];
        $password = Yii::$app->params['instagram']['password'];
        $user_id = Yii::$app->params['instagram']['user_id'];



        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $Instagram = new Instagram();


        try {
            $loginResponse = $Instagram->login($username, $password);


            if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) {

                echo 'two';
                echo '<pre>';
                print_r($loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier());
                echo '</pre>';
            }

            echo 'good';

        } catch (\Exception $Exception) {

            if ($Exception instanceof ChallengeRequiredException) {
                sleep(5);

                $customResponse = $Instagram
                    ->request(substr($Exception->getResponse()->getChallenge()->getApiPath(), 1))
                    ->setNeedsAuth(false)
                    ->addPost("choice", 0)
                    //->addPost("security_code", '873409')
                    ->getDecodedResponse();

                echo '<pre>';
                print_r($customResponse);
                echo '</pre>';
            }else{
                echo $Exception->getMessage();
                echo '<pre>';
                print_r($Exception);
                echo '</pre>';
            }
        }



    }

    public function actionFix2()
    {
        $username = Yii::$app->params['instagram']['username'];
        $password = Yii::$app->params['instagram']['password'];
        $user_id = Yii::$app->params['instagram']['user_id'];

        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $Instagram = new Instagram();


        try {

            $loginResponse = $Instagram->changeUser($username, $password);
            $customResponse = $Instagram
                ->request("challenge/$user_id/bLNrXq5hyA/")
                ->setNeedsAuth(false)
                ->addPost("security_code", '873409')
            ->getDecodedResponse();

            echo '<pre>';
            print_r($customResponse);
            echo '</pre>';

        } catch (\Exception $Exception) {

            echo $Exception->getMessage();
            echo '<pre>';
            print_r($Exception);
            echo '</pre>';
        }

    }
    public function actionIndex()
    {
        $results = [];
        try {
            $results = InstagramModel::getAll();
        }  catch (\Exception $exception) {
            echo '<pre>';
            print_r($exception);
            echo '</pre>';
        }
        return $this->render('index', ['results'=>$results]);
    }
    public function actionClean()
    {
        InstagramModel::removeAll();
    }
}