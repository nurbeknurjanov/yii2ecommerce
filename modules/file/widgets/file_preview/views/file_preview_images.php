<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use file\models\FileImage;



if($images){
    ?>
    <div class="file-preview form-control" style="height:auto;">
        <div class="file-drop-disabled">
            <div class="file-preview-thumbnails" >
                <?php
                foreach ($images as $image) {
                    $deleteLink=Html::a('<i class="glyphicon glyphicon-trash text-danger"></i>', ['/file/file-image/delete', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default',
                        'data' =>[
                            'form'=>'anotherForm',
                            'confirm'=>Yii::t('common', 'Are you sure you want to delete this item?')]]);
                    $mainLink=Html::a('<i class="glyphicon glyphicon-unchecked"></i>', ['/file/file-image/main', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default']);
                    if($image->type==FileImage::TYPE_IMAGE_MAIN)
                        $mainLink=Html::a('<i class="glyphicon glyphicon-log-out"></i>', ['/file/file-image/not-main', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default']);

                    ?>
                    <div class="file-preview-frame  krajee-default  kv-preview-thumb" style="display: block; height: auto">
                        <a href="<?=$image->imageUrl;?>" data-lightbox="file-preview">
                            <?=$image->getImg($thumbType);?>
                        </a>
                        <div class="file-thumbnail-footer">
                            <div title="<?=$image->title;?>" class="file-footer-caption"><?=$image->title;?></div>
                            <?php
                            if($actions){
                                ?>
                                <div class="file-actions">
                                    <div class="file-footer-buttons">
                                        <?=$mainLink;?>
                                        <?=$deleteLink;?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}

?>


