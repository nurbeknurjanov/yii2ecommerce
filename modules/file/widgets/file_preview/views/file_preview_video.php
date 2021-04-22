<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;

echo \file\widgets\file_video_network\FileVideoNetworkWidget::widget();

if($video){
    $deleteLink=Html::a('<i class="glyphicon glyphicon-trash text-danger"></i>', ['/file/file-video-network/delete', 'id'=>$video->id], ['class'=>'kv-file-remove btn btn-xs btn-default','data' =>[ 'form'=>'anotherForm','confirm'=>Yii::t('common', 'Are you sure you want to delete this item?')]]);
    ?>
    <div class="clear"></div>
    <div class="file-preview-frame krajee-default  kv-preview-thumb" style="display: block; height: auto;">
        <?=$video->getImg($options, ['class'=>'video-image video-image-little',]);?>
        <div class="file-thumbnail-footer">
            <div title="<?=$video->title;?>" class="file-footer-caption"><?=$video->title;?></div>
            <?php
            if($actions){
                ?>
                <div class="file-actions">
                    <div class="file-footer-buttons">
                        <?=$deleteLink;?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>
    <?php
}


