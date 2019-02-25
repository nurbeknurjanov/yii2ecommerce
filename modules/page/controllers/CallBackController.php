<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\controllers;


use extended\controller\Controller;
use page\models\CallBackForm;
use Yii;


class CallBackController extends Controller
{
    public function behaviors()
    {
        return [
        ];
    }
    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new CallBackForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('page', 'Thank you for contacting us. We will call to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->goAlert();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}