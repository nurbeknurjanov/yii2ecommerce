<?php

namespace user\controllers;

use user\models\Token;
use Yii;
use user\models\User;
use extended\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 */
class TokenController extends Controller
{
    protected function findModel($id)
    {
        if (($model = Token::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Finds the Token model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $token
     * @return Token the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByToken($token)
    {
        if (($model = Token::find()->where(['token'=>$token,])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionKoko()
    {
        Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully changed your email.'));
        return $this->goAlert();
    }
    public function actionRun($token)
    {
        if($model = $this->findModelByToken($token)){
            try {
                $model->run();

                $user = $model->user;
                switch($model->action){
                    case Token::ACTION_ACTIVATE_ACCOUNT: {

                        Yii::$app->mailer->compose()
                            ->setTo([$user->email=>$user->fullName,])
                            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                            ->setSubject(Yii::t('user', 'You successfully activated your account.'))
                            ->setHtmlBody(Yii::t('user', 'You successfully activated your account.'))
                            ->send();

                        Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully activated your account.'));

                        if($model->data=='auto_login')
                            Yii::$app->user->login($user);

                        //return $this->redirect(Yii::$app->user->loginUrl);
                        if(!$user->password_hash){
                            Yii::$app->session->setFlash('info', Yii::t('user', 'Please, set your password.'));
                            return $this->redirect(['/user/profile/set-password', 'next'=>"profileData"]);
                        }
                        Yii::$app->session->setFlash('info', Yii::t('user', 'Please, fill in your profile data.'));
                        return $this->redirect(['/user/profile/edit-profile']);


                        break;
                    }
                    case Token::ACTION_COMPLETE_ACCOUNT: {

                        Yii::$app->user->login($user);

                        if(!$user->password_hash){
                            Yii::$app->session->setFlash('info', Yii::t('user', 'Please, set your password.'));
                            return $this->redirect(['/user/profile/set-password', 'next'=>"profileData"]);
                        }

                        Yii::$app->session->setFlash('info', Yii::t('user', 'Please, fill in your profile data.'));
                        return $this->redirect(['/user/profile/edit-profile']);

                        break;
                    }

                    case Token::ACTION_CHANGE_EMAIL: {
                        unset($model->user);
                        $user = $model->user;
                        Yii::$app->mailer->compose()
                            ->setTo([$user->email=>$user->fullName,])
                            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                            ->setSubject(Yii::t('user', 'You successfully changed your email.'))
                            ->setHtmlBody(Yii::t('user', 'You successfully changed your email.'))
                            ->send();
                        Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully changed your email.'));
                        break;
                    }

                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->goAlert();
    }


}
