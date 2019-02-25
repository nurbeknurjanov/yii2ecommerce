<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace console\controllers;

use console\models\Upwork;
use console\models\SMSRU;
use yii\console\Controller;
use user\modules\delivery\models\CronEmailMessage;
use user\models\User;
use user\models\Token;
use Yii;
use yii\base\Exception;
use yii\helpers\StringHelper;

class UpworkController extends Controller
{
    public function actionIndex()
    {

        $url = "https://www.upwork.com/ab/feed/topics/rss?securityToken=1d30c9608fdd407384c9133374eb7a124e2afb5c8cfab33e4c127822bc0d14d0b1a026fa90f91ebbddca64eefa01ac34258811c1883d0cf170e893b456d3cd39&userUid=424169751357669376&orgUid=424169751361863681&topic=1811945";
        $xml = simplexml_load_file($url);
        foreach ($xml->channel->item as $item){

            $title = preg_replace('/^\s*\/\/<!\[CDATA\[([\s\S]*)\/\/\]\]>\s*\z/',  '$1',  $item->title);
            $title = str_replace(" - Upwork", "", $title);
            $title = StringHelper::truncate($title, 200);


            $description = preg_replace('/^\s*\/\/<!\[CDATA\[([\s\S]*)\/\/\]\]>\s*\z/',  '$1',  $item->description);
            $description = strip_tags($description, '<br><b><p>');

            $date = strtotime($item->pubDate);
            $date = date('Y-m-d H:i:s', $date);

            $jobExists = Upwork::find()
                ->findTitleAndDate($title, $date)->exists();

            if(!$jobExists){
                $newJob = new Upwork();
                $newJob->title = $title;
                $newJob->date = $date;
                $newJob->description = $description;
                //$newJob->link =  StringHelper::truncate($item->link, 100);
                $newJob->link =  $item->link;
                $newJob->guid =  StringHelper::truncate($item->guid, 100);
                $newJob->save(false);
            }
        }
    }
}