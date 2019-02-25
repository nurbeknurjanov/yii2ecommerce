<?php

use product\models\Product;
use order\models\OrderProduct;
use order\models\Order;
use Codeception\Scenario;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    public function getScenario()
    {
        return parent::getScenario();
    }

    use _generated\AcceptanceTesterActions;

    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $assetsDir = Yii::getAlias('@frontend').'/web/assets/*';
        exec("chmod -R 777 ".$assetsDir);

        $this->maximizeWindow();
        //$this->resizeWindow(1900, 1000);
    }

}
