<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace user\controllers;

use file\models\File;
use user\models\create\TokenCreate;
use user\models\InviteForm;
use user\models\Token;
use user\models\User;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\filters\AccessControl;
use yii\helpers\Html;
use extended\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;


class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile', 'edit-profile', 'set-password', 'change-password', 'change-email',
                            'activate-email-change', 'share', 'invite', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => Yii::$app->user->identity,
        ]);
    }

    public function actionEditProfile()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = User::SCENARIO_EDIT_PROFILE;

        $profile = $model->userProfileObject;
        $profile->userObject = $model;


        if(Yii::$app->request->isAjax)
            Yii::$app->response->format = Response::FORMAT_JSON;


        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            $profile->load(Yii::$app->request->post());

            if(Yii::$app->request->post('ajax'))
                return array_merge(ActiveForm::validate($model), ActiveForm::validate($profile));

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if(!$model->save())
                    throw new Exception(Html::errorSummary($model, ['header'=>false]));
                if(!$profile->save())
                    throw new Exception(Html::errorSummary($profile, ['header'=>false]));

                $transaction->commit();


                Yii::$app->session->setFlash('successMessage', 'Changes successfully was saved.');
                return $this->refresh();
                /*if($model->language)
                    Yii::$app->language = $model->language;*/
                /*if(!Yii::$app->request->isPjax){
                    if($model->language)
                        return $this->redirect(Url::to(['/user/profile/edit-profile', 'language'=>$model->language]));
                    return $this->refresh();
                }*/

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', $e->getMessage());
            }

        }


        return $this->render('editProfile', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }



    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;
        if(!$model->password_hash)
            $this->redirect(['set-password']);
        $model->scenario = 'changePassword';
        $this->performAjaxValidation($model, ['password', 'password_new', 'password_new_repeat']);

        if ($model->load(Yii::$app->request->post()) && $model->validate(['password', 'password_new', 'password_new_repeat'])){
            $model->setPassword($model->password_new);
            $model->save(false);
            Yii::$app->session->setFlash('successMessage', Yii::t('user', 'You successfully changed your password.'));
            return $this->refresh();
        }else{
            $model->password_new = null;
            $model->password_new_repeat = null;
        }
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
    public function actionSetPassword()
    {
        $model = Yii::$app->user->identity;
        if($model->password_hash)
            $this->redirect(['change-password']);
        $model->scenario='setPassword';
        $this->performAjaxValidation($model, ['password_set', 'password_set_repeat']);

        if($model->load(Yii::$app->request->post()) && $model->validate(['password_set', 'password_set_repeat'])){
            $model->setPassword($model->password_set);
            $model->save(false);
            if(Yii::$app->request->getQueryParam('next')=='profileData'){
                Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully set your password.'));
                Yii::$app->session->setFlash('info', Yii::t('user', 'Please, fill in your profile data.'));
                return $this->redirect(['/user/profile/edit-profile']);
            }
            Yii::$app->session->setFlash('successMessage', Yii::t('user', 'You successfully set your password.'));
            return $this->refresh();
        }
        return $this->render('setPassword', [
            'model' => $model,
        ]);
    }

    public function actionChangeEmail()
    {
        $user = Yii::$app->user->identity;
        $user->scenario = 'changeEmail';
        $this->performAjaxValidation($user, ['email_new', 'password']);

        if ($user->load(Yii::$app->request->post()) && $user->validate(['email_new', 'password'])){
            $token = TokenCreate::create(Token::ACTION_CHANGE_EMAIL, $user, $user->email_new);
            Yii::$app->mailer->compose('approveNewEmail-html', ['user' => $user, 'token'=>$token,])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo([$user->email_new=>$user->fullName])
                ->setSubject(Yii::t('user', 'Approve to change your email.'))
                ->send();
            Yii::$app->session->setFlash('success', Yii::t('user', 'We sent to your new email a link to approve to change your email.'));
            return $this->refresh();
        }
        return $this->render('changeEmail', [
            'model' => $user,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

} 