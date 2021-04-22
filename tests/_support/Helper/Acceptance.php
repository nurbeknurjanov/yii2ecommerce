<?php
namespace Helper;

use Yii;
use extended\helpers\Helper;
use product\models\Product;
use order\models\OrderProduct;
use order\models\Order;
use AcceptanceTester;
use category\models\Category;
use yii\helpers\Url;
use user\models\User;
use user\models\LoginForm;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{

    public function clearEmails()
    {
        $dir = Yii::getAlias('@frontend')."/web/assets/mails";
        if(is_dir($dir))
            Helper::emptydir($dir);
        //shell_exec("rm -r $frontend_dir/runtime/*");

        //Yii::$app->mailer->fileTransportPath = '@frontend/web/assets/mails';
    }
    public function getEmails()
    {
        $emails=[];
        $dir = Yii::getAlias('@frontend')."/web/assets/mails";
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object)
                if ($object != "." && $object != ".."){
                    $new_name = str_replace('eml','html', $object);
                    rename($dir."/".$object, $dir.'/'.$new_name);
                    $emails[] = $new_name;
                    //$emails[] = file_get_contents($dir."/".$object);
                }
        }
        return $emails;
    }


    public function goToCategory(AcceptanceTester $I, Category $category)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->seeLink($category->title);
        $I->click($category->title);
        $I->wait(1);
    }

    public function goToProduct(AcceptanceTester $I, Product $product)
    {
        $I->amOnPage(Url::to($product->url));
        $I->waitForText($product->title);
        $I->seeInCurrentUrl($product->title_url);
    }

    public function openMenu(AcceptanceTester $I)
    {
        $I->moveMouseOver( '.navbar-top .navbar-right li:nth-last-child(3) > a' );
    }
    public function logout(AcceptanceTester $I)
    {
        $this->openMenu($I);
        $I->waitForText(Yii::t('common', 'Logout'));
        $I->click(Yii::t('common', 'Logout'));
    }
    public function login(AcceptanceTester $I, $login='admin', $password=123123, $clickLoginLinks=true)
    {
        if($clickLoginLinks){
            //$I->amOnPage(Url::to(Yii::$app->user->loginUrl));
            $I->amOnPage(Url::to(Yii::$app->homeUrl));
            $I->seeLink(Yii::t('common', 'Login'));
            $I->click(Yii::t('common', 'Login'));
        }

        $loginForm = new LoginForm;
        $I->waitForText($loginForm->getAttributeLabel('username'));
        $I->fillField($loginForm->formName()."[username]", $login);
        $I->fillField(['name' => $loginForm->formName()."[password]"], $password);
        //$I->click('.form-group button');
        $I->click(['css'=>'.form-group button']);
        //$I->click(['name'=>'login-button']);

        //$user = $I->grabRecord(User::class);//пашет если haveFixtures
        //$user= User::find()->one();//пашет если haveFixtures
        //\Codeception\Util\Debug::debug($user);
        /* echo "\n";
        echo $user->name."\n";
        echo $user->email."\n";
        echo "\n"; */
        //$I->waitForText($user->fullName);

        $name = $I->grabFromDatabase('user',  'name',   [
                                    'email' => $login,
                                ]);
        if(!$name)
            $name = $I->grabFromDatabase('user',  'name',   [
                                            'username' => $login,
                                        ]);
        $I->waitForText($name);
    }

    public function showBasket(AcceptanceTester $I, Product $model, $hiddenField=true)
    {
        $orderProduct = new OrderProduct;
        $I->waitForElementNotVisible('#basketModal');

        $I->seeElement('#showBasket-'.$model->id);
        $I->click('#showBasket-'.$model->id);

        $I->waitForElementVisible('#basketModal');

        if($hiddenField)
            $I->seeInField("input[name='{$orderProduct->formName()}[product_id]'][type=hidden]", (string) $model->id);
        else{
            $I->waitForElement("select[name='{$orderProduct->formName()}[product_id]']");
            $I->seeOptionIsSelected("select[name='{$orderProduct->formName()}[product_id]']", $model->title);
        }
        $I->seeInField($orderProduct->formName().'[price]',(string) $model->price);
        $I->seeInField($orderProduct->formName().'[count]', '1');
        //$I->cantSeeInField('user[name]', 'Miles');
        //$I->grabValueFrom('input[name=api]');
    }
}
