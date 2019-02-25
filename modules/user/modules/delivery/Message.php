<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace delivery;


class Message extends \yii\swiftmailer\Message
{
    private $_body;
    public function setHtmlBody($html)
    {
        $this->_body = $html;
        return $this;
    }
    public function setTextBody($text)
    {
        $this->_body = $text;
        return $this;
    }
    public function getBody()
    {
        return $this->_body;
    }
} 