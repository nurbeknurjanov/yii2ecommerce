<?php

use yii\helpers\Url;
use tests\unit\fixtures\UserFixture;
use user\models\Token;
use yii\test\ActiveFixture;
use user\models\LoginForm;
use user\models\User;
use user\models\PasswordResetRequestForm;
use user\models\ResetPasswordForm;
use user\models\SignupForm;

class UserCest
{
    public function _fixtures()
    {
        $fixtures = [
            'tokens_null' => [
                'class' => ActiveFixture::class,
                'tableName'=>Token::tableName(),
                'depends'=>[],
            ],
            'users' => [
                'class' => UserFixture::class,
                'depends'=>[],
                'dataFile'=>false,
            ],
        ];
        return $fixtures;
    }

    public function _before(AcceptanceTester $I)
    {
        $I->clearEmails();
        if(in_array($I->getScenario()->getFeature(),['test login',
                                        'forgot password', 'change password',
                                        'set password','edit profile', 'change email'])){
            $I->haveFixtures([
                'users' => [
                    'class' => UserFixture::class,
                    'depends'=>[],
                    'dataFile'=>null,
                ],
            ]);
        }
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function testLogin(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        //$this->tester;
        //$this->tester->haveRecord('app/model/User', ['username' => 'davert']);
        //$helper->login($I);
        $I->login($I);
    }
    public function forgotPassword(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $user = $I->grabFixture('users', 0);
        $I->amOnPage(Yii::$app->homeUrl);
        $I->click(Yii::t('common', 'Login'));
        $I->waitForText(Yii::t('user', 'reset it'));
        $I->click(Yii::t('user', 'reset it'));
        $I->waitForText(Yii::t('common', 'Request password reset'));
        $form = new PasswordResetRequestForm();
        $I->fillField($form->formName().'[email]', $user->email);
        $I->click(Yii::t('common', 'Send'));
        $I->waitForElement('.alert-success');
        $I->wait(2);
        $emails = $I->getEmails();
        $I->amOnPage('/assets/mails/'.$emails[0]);
        $I->waitForText(Yii::t('user', 'Password reset for {appName}', ['appName'=>Yii::$app->name,]));
        $I->amOnPage(Url::to(['/user/guest/reset-password',
            'token' => $I->grabFromDatabase('user_token', 'token')]));
        $I->waitForText(Yii::t('user', 'Reset password'));

        $I->fillField('ResetPasswordForm[password]', 321321);
        $I->fillField('ResetPasswordForm[password_repeat]', 321321);
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');

        $I->login($I, $user->email, 321321);
        $I->waitForText($user->fullName);
    }
    public function changeEmail(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $user = $I->grabFixture('users', 0);
        $I->login($I);
        $I->openMenu($I);

        $I->click(Yii::t('user', 'Change email'));

        $I->waitForText(Yii::t('user', 'Change email'));

        $I->fillField($user->formName().'[email_new]', 'another@mail.ru');
        $I->fillField($user->formName().'[password]', 123123);
        $I->click(Yii::t('common', 'Send'));
        $I->performOn('.bootbox',
            \Codeception\Util\ActionSequence::build()
                ->waitForText(Yii::t('user', 'Are you sure to change your email ?'))
                ->click(Yii::t('common', 'CONFIRM'))
        );
        /*$I->waitForElementVisible('.bootbox');
        $I->waitForText(Yii::t('user', 'Are you sure to change your email ?'));
        $I->click(Yii::t('common', 'CONFIRM'));
        $I->waitForElementNotVisible('.bootbox');*/


        $I->waitForElement('.alert-success');
        $I->wait(2);
        $emails = $I->getEmails();
        $I->amOnPage('/assets/mails/'.$emails[0]);
        $I->waitForText(Yii::t('user', 'Approve to change your email.'));
        $I->amOnPage(Url::to(['/user/token/run',
            'token' => $I->grabFromDatabase('user_token', 'token')]));
        $I->waitForElement('.alert-success');


        $I->logout($I);

        $I->login($I, 'another@mail.ru', 123123);
        $I->waitForText($user->fullName);
    }

    public function signUp(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $usersFixture = new UserFixture([
            'depends'=>[],
        ]);
        $data = $usersFixture->getData()[0];
        $I->amOnPage(Yii::$app->homeUrl);
        $I->click(Yii::t('common', 'Login'));
        $I->click(Yii::t('user', 'Sign up'));


        $form = new SignupForm;
        $I->fillField($form->formName().'[name]', $data['name']);
        $I->fillField($form->formName().'[email]', $data['email']);
        $I->fillField($form->formName().'[password]', 123123);
        $I->fillField($form->formName().'[password_repeat]', 123123);
        $I->click(Yii::t('user', 'Next'));

        $I->waitForText($form->getAttributeLabel('accept_terms'));
        $I->checkOption($form->formName().'[accept_terms]');
        $I->click(Yii::t('user', 'Finish'));
        $I->waitForElement('.alert-success');

        $I->wait(4);
        $emails = $I->getEmails();
        $I->amOnPage('/assets/mails/'.$emails[0]);
        $I->waitForText(Yii::t('user', 'You requested to activate your account.'));
        $I->see(Yii::t('common', 'Activate'));
        $I->amOnPage(Url::to(['/user/token/run',
            'token' => $I->grabFromDatabase('user_token', 'token')]));

        $I->waitForElement('.alert-success');
        $I->see($data['name']);

        $I->logout($I,$data['name']);

        $I->login($I, $data['email'],123123);
        $I->waitForText($data['name']);
    }

    public function editProfile(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $I->login($I);
        $user = $I->grabFixture('users', 0);
        $I->openMenu($I);
        $I->click(Yii::t('user', 'Edit profile'));
        $I->see(Yii::t('user', 'Edit profile'), 'h1');

        $I->fillField($user->formName().'[name]', 'Nick Carter');
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');
        $I->reloadPage();
        $I->see('Nick Carter');
    }
    public function changePassword(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $I->login($I);
        $user = $I->grabFixture('users', 0);
        //$I->click($user->fullName);
        $I->openMenu($I);

        $I->click(Yii::t('user', 'Change password'));
        $I->see(Yii::t('user', 'Change password'), 'h1');

        $I->fillField($user->formName().'[password]', 123123);
        $I->fillField($user->formName().'[password_new]', 321321);
        $I->fillField($user->formName().'[password_new_repeat]', 321321);
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');

        $I->logout($I);

        $I->login($I, $user->email, 321321);
    }
    protected function setPassword(AcceptanceTester $I, \Helper\Acceptance $helper)
    {
        $user = $I->grabFixture('users', 0);
        $I->login($I);

        $I->updateInDatabase('user', ['password_hash'=>'']);
        $I->reloadPage();

        $I->click($user->fullName);
        $I->click(Yii::t('user', 'Set password'));
        $I->see(Yii::t('user', 'Set password'), 'h1');

        $I->fillField($user->formName().'[password_set]', 321321);
        $I->fillField($user->formName().'[password_set_repeat]', 321321);
        $I->click(Yii::t('common', 'Save'));
        $I->waitForElement('.alert-success');

        $I->logout($I);
        $I->login($I, $user->email, 321321);
    }
}
