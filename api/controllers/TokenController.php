<?php

namespace api\controllers;

use user\models\create\TokenCreate;
use user\models\User;
use user\models\Token;
use user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use extended\controller\Controller;

/**
 */
class TokenController extends \yii\rest\Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
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

                        return "success";
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

                    case Token::ACTION_INVITE_FROM_ORDER: {

                        $model->refresh();
                        $user = $model->user;

                        Yii::$app->mailer->compose()
                            ->setTo([$user->email=>$user->fullName,])
                            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                            ->setSubject(Yii::t('user', 'You successfully signed up.'))
                            ->setHtmlBody(Yii::t('user', 'You successfully signed up.'))
                            ->send();

                        Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully signed up.'));

                        Yii::$app->user->login($user);

                        if(!$user->password_hash){
                            Yii::$app->session->setFlash('info', Yii::t('user', 'Please, set your password.'));
                            return $this->redirect(['/user/profile/set-password', 'next'=>"profileData"]);
                        }
                        Yii::$app->session->setFlash('info', Yii::t('user', 'Please, fill in your profile data.'));
                        return $this->redirect(['/user/profile/edit-profile']);
                        break;
                    }



                }
            } catch (Exception $e) {
                //throw new $e;
                throw new HttpException(400, $e->getMessage());
            }
        }
    }


}
