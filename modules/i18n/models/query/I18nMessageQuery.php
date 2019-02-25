<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace i18n\models\query;

use i18n\models\I18nMessage;

/**
 * This is the ActiveQuery class for [[\i18n\models\I18nMessage]].
 *
 * @see \i18n\models\I18nMessage
 */
class I18nMessageQuery extends \yii\db\ActiveQuery
{

    public function defaultFrom()
    {
        return $this->from(['i18n_message'=>I18nMessage::tableName()]);
    }
    public function whereByQ($q)
    {
        $this->addOrderBy("MATCH (i18n_message.translation) AGAINST (:q  IN BOOLEAN MODE) DESC");
        $this->andWhere("MATCH (i18n_message.translation) AGAINST (:q  IN BOOLEAN MODE)")->addParams([':q'=>$q]);
        return $this;
    }

    public function language()
    {
        return $this->andWhere("[[language]]='".\Yii::$app->language."'");
    }
    public function translated()
    {
        return $this->andWhere("[[translation]]!='' AND [[translation]] IS NOT NULL");
    }

    /**
     * @inheritdoc
     * @return \i18n\models\I18nMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \i18n\models\I18nMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
