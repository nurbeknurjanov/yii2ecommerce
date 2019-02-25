<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use category\models\Category;

if(isset($this->params['category']) && $category = $this->params['category']){

    $children = Category::getDb()->cache(function ($db) use($category) {
        return $category->children(1)->enabled()->with('image')->all();
    });

    if($children){
        ?>
        <h1 class="categoryTitle"><?=$category->title;?></h1>
        <ul class="categoryBlock">
            <?php
            foreach ($children as $child) {
                $title = $child->title;
                if($child->image)
                    $title=Html::img($child->image->imageUrl, ['class'=>'category-icon']).$title;
                ?>
                <li>
                    <?=Html::a($title, $child->url, ['style'=>'font-weight:600; color: #535353;'])?>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
}
