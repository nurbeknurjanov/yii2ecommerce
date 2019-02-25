<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use extended\controller\Controller;
use product\models\Compare;
use product\models\Product;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use product\models\search\ProductSearchFrontend;
use Yii;
use InstagramAPI\Instagram;
use InstagramAPI\Media\Photo\InstagramPhoto;
use InstagramAPI\Media\Photo\PhotoDetails;
use InstagramAPI\Media\Video\VideoDetails;

class InstagramModel
{

    public static $_connection;
    public static function connect()
    {
        if(self::$_connection)
            return self::$_connection;

        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $ig = new Instagram();
        $ig->login(Yii::$app->params['instagram']['username'], Yii::$app->params['instagram']['password']);
        return self::$_connection = $ig;
    }

    //$result = $ig->media->getInfo('1841329991122231146_344733174');

    public static function create(Product $product)
    {
        $ig = self::connect();

        if(count($product->images)==1){
            $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($product->getImages()->one()->filePath);
            return $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $product->externalNetworkText]);
        }


        if(count($product->images)>1){
            $media=[];
            foreach ($product->images as $image)
                $media[]=[
                    'type'     => 'photo',
                    'file'     => $image->filePath,
                ];

            $mediaOptions = ['targetFeed' => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM ];
            foreach ($media as &$item) {
                $validMedia = null;
                switch ($item['type']) {
                    case 'photo':
                        $validMedia = new \InstagramAPI\Media\Photo\InstagramPhoto($item['file'], $mediaOptions);
                        break;
                    case 'video':
                        $validMedia = new \InstagramAPI\Media\Video\InstagramVideo($item['file'], $mediaOptions);
                        break;
                    default:
                }
                if ($validMedia === null)
                    continue;
                try {
                    $item['file'] = $validMedia->getFile();
                    $item['__media'] = $validMedia; // Save object in an unused array key.
                } catch (\Exception $e) {
                    continue;
                }
                if (!isset($mediaOptions['forceAspectRatio'])) {
                    // Use the first media file's aspect ratio for all subsequent files.
                    $mediaDetails = $validMedia instanceof InstagramPhoto  ? new PhotoDetails($item['file'])  : new VideoDetails($item['file']);
                    $mediaOptions['forceAspectRatio'] = $mediaDetails->getAspectRatio();
                }
            }
            unset($item);
            //return $ig->timeline->uploadPhoto($filePath /*new InstagramPhoto($filePath);*/, ['caption' => $product->title]);
            return $ig->timeline->uploadAlbum($media, ['caption' => $product->externalNetworkText]);
        }
    }
    protected static function removeById($instagram_id)
    {
        $ig = self::connect();
        $ig->media->delete($instagram_id);
    }
    public static function remove(Product $product)
    {
        self::removeById($product->productNetworkInstagram->network_id);
    }
    public static function updateData(Product $product)
    {
        $ig = self::connect();
        return $ig->media->edit($product->productNetworkInstagram->network_id, $product->externalNetworkText);
    }
    public static function update(Product $product)
    {
        self::remove($product);
        return self::create($product);
    }


    public static function removeAll()
    {
        $items = self::getAll();
        foreach ($items as $item) {
            self::removeById($item['id']);
        }
    }


    /*
 * Array
(
[0] => Array
    (
        [id] => 1911600859362227622_8986991017
        [title] => Asus
        [images] => Array
            (
                [0] => https://instagram.ffru2-1.fna.fbcdn.net/vp/c6b18f63854d11493bad9025fb00a84e/5C70C912/t51.2885-15/e35/44250722_332380460880113_1829052533490207525_n.jpg?se=7&ig_cache_key=MTkxMTYwMDgwNDcxNzM3NTg4Mw%3D%3D.2
                [1] => https://instagram.ffru2-1.fna.fbcdn.net/vp/0d9fd898c2038c7759d31a557402361c/5C7DCE4F/t51.2885-15/e35/44896517_269100597285466_8996876574126685847_n.jpg?se=8&ig_cache_key=MTkxMTYwMDgxOTA3ODU1NDM0Mg%3D%3D.2
                [2] => https://instagram.ffru2-1.fna.fbcdn.net/vp/bd7427a242bfb48f8fcafb6b9e877345/5C6FC766/t51.2885-15/e35/43040811_2201273306780736_3458259581735196638_n.jpg?se=8&ig_cache_key=MTkxMTYwMDgzNzYwOTEwODg3MQ%3D%3D.2
                [3] => https://instagram.ffru2-1.fna.fbcdn.net/vp/d364e6062d97538b04c184717d84ab6a/5C871A0E/t51.2885-15/e35/44715203_344669466081897_8524920028675903866_n.jpg?ig_cache_key=MTkxMTYwMDg0Nzk0MzY5NjAwOA%3D%3D.2
            )

    )

)
*/
    public static function getAll()
    {
        $ig = self::connect();
        $result = [];
        $userId = $ig->people->getUserIdForName(Yii::$app->params['instagram']['username']);
        //$maxId = '1841326011726057726_344733174';
        $maxId = null;

        $response = $ig->timeline->getUserFeed($userId, $maxId);
        foreach ($response->getItems() as $item) {
            $data = ['id'=>$item->getId()];
            $data['title']='';
            if($caption = $item->getCaption())
                $data['title'] = $caption->getText();
            if($item->getCarouselMedia()){
                foreach ($item->getCarouselMedia() as $album)
                    $data['images'][] = $album->getImageVersions2()->getCandidates()[0]->getUrl();
            }else
                $data['image'] = $item->getImageVersions2()->getCandidates()[0]->getUrl();
            $result[] = $data;
        }
        return $result;
    }
}