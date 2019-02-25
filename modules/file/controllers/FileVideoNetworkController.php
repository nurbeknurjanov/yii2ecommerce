<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\controllers;


use article\models\Article;
use extended\controller\Controller;
use extended\helpers\Html;
use file\models\FileVideoNetwork;
use file\models\VideoNetwork;
use yii\web\NotFoundHttpException;

class FileVideoNetworkController extends FileController
{
    public function behaviors()
    {
        return [];
    }
    public function actionImg()
    {
        $model = new FileVideoNetwork;
        $model->scenario = 'image';
        $model->load($_GET);
        if($model->validate(['link'])){
            return $this->renderPartial('img', ['model'=>$model]);
        }
    }
    public function actionVideo($id=null, $file_name=false)
    {
        if($id){
            $model = FileVideoNetwork::findOne($id);
            return $this->renderPartial('video', ['model'=>$model]);
        }
        elseif($file_name){
            $model = new FileVideoNetwork(['file_name'=>$file_name]);
            if($model->validate(['link']))
                return $this->renderPartial('video', ['model'=>$model]);
        }
    }

    protected function findModel($id)
    {
        if (($model = FileVideoNetwork::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}