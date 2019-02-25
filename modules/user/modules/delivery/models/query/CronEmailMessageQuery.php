<?php

namespace delivery\models\query;

use delivery\models\CronEmailMessage;

/**
 * This is the ActiveQuery class for [[\delivery\models\CronEmailMessage]].
 *
 * @see \delivery\models\CronEmailMessage
 */
class CronEmailMessageQuery extends \yii\db\ActiveQuery
{
    public function open()
    {
        $this->andWhere(['status'=>CronEmailMessage::STATUS_OPEN,]);
        return $this;
    }
    public function sent()
    {
        $this->andWhere(['status'=>CronEmailMessage::STATUS_SENT,]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \delivery\models\CronEmailMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \delivery\models\CronEmailMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}