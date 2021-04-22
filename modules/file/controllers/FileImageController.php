<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 5/16/16
 * Time: 10:49 AM
 */

namespace file\controllers;

use file\models\FileImage;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use product\models\FileImageProduct;
use product\models\Product;
use Yii;
use file\models\File;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\web\Response;

class FileImageController extends \file\controllers\FileController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['resize',],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['main', 'not-main',],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action)
                            {
                                if(!isset($_GET['id']))
                                    throw new Exception("id parameter is missing");
                                $file =$this->findModel($_GET['id']);
                                return Yii::$app->user->can('update'.$file->shortModelName, ['model' => $file->model]);
                            }
                    ],
                ],
            ],
        ]);
    }

    public function actionMain($id)
    {
        $model = $this->findModel($id);
        $model->type=FileImage::TYPE_IMAGE_MAIN;
        $model->save(false);

        File::updateAll(['type'=>FileImage::TYPE_IMAGE],
            ['AND',
                ["!=", 'id', $model->id],
                ['model_id'=>$model->model_id, 'model_name'=>$model->model_name],
                ['type'=>FileImage::TYPE_IMAGE_MAIN] 
            ] );
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionNotMain($id)
    {
        $file = $this->findModel($id);
        $file->type=FileImage::TYPE_IMAGE;
        $file->save(false);

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionResize()
    {
        $models = FileImage::findAll(['model_name'=>Product::class]);
        foreach ($models as $model) {
            $file = new UploadedFile();
            $file->name = 'somename';

            $fip = new FileImageProduct;

            $file->tempName =  (new File())->copy($model->imageUrl) ;
            $imagine = Image::getImagine();


            $dest = Yii::getAlias('@tests')."/unit/fixtures/files/product/{$model->model->id}/thumb/md-".$model->file_name;
            copy($file->tempName, $dest);
            $image = $imagine->open($dest);
            $size = new Box($fip->thumbMdWidth, $fip->thumbMdHeight);
            if($fip->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($dest  );
                \extended\imagine\Imagine::pad($dest, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($dest );


            $dest = Yii::getAlias('@tests')."/unit/fixtures/files/product/{$model->model->id}/thumb/sm-".$model->file_name;
            copy($file->tempName, $dest);
            $image = $imagine->open($dest);
            $size = new Box($fip->thumbSmWidth, $fip->thumbSmHeight);
            if($fip->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($dest  );
                \extended\imagine\Imagine::pad($dest, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($dest );

            $dest = Yii::getAlias('@tests')."/unit/fixtures/files/product/{$model->model->id}/thumb/xs-".$model->file_name;
            copy($file->tempName, $dest);
            $image = $imagine->open($dest);
            $size = new Box($fip->thumbXsWidth, $fip->thumbXsHeight);
            if($fip->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($dest  );
                \extended\imagine\Imagine::pad($dest, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($dest );
        }

        /*$models = FileImage::findAll(['model_name'=>Room::class]);
        foreach ($models as $model) {
            $file = new UploadedFile();
            $file->name = 'sm.jpg';

            $file->tempName =  (new File())->copy($model->imageUrl) ;

            $dest = Yii::getAlias('@tests')."/unit/fixtures/files/room/{$model->model->id}/thumb/sm-".$model->file_name;
            copy($file->tempName, $dest);
            $image = Image::getImagine();
            $image = $image->open($dest);
            $size = new Box(120, 120);
            $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($dest, ['quality' => 60] );
        }*/
    }
} 