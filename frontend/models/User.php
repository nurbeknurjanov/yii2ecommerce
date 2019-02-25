<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace frontend\models;


class User extends \user\models\User
{
    /*
    * returns first_name, last_name, email, sex, birth_date,
    * photo
    * city, country
    */
    public static function customizeAttributes($attributes, $authClient)
    {
        switch($authClient){
            case 'facebook':{
                unset($attributes['name']);
                if(isset($attributes['gender']))
                {
                    $attributes['sex']=$attributes['gender']=='male'?1:0;
                    unset($attributes['gender']);
                }
                if(isset($attributes['birthday']))
                {
                    $attributes['birth_date']=date_create_from_format('m/d/Y', $attributes['birthday'])->format('Y-m-d');
                    unset($attributes['birthday']);
                }
                unset($attributes['locale']);

                if(isset($attributes['location'], $attributes['location']['name']))
                {
                    $location=explode(', ', $attributes['location']['name']);
                    $attributes['city']=$location[0];
                    $attributes['country']=$location[1];
                    unset($attributes['location']);
                }
                if(isset($attributes['picture'], $attributes['picture']['data'],$attributes['picture']['data']['url']))
                {
                    $attributes['photo']=$attributes['picture']['data']['url'];
                    unset($attributes['picture']);
                }
                $attributes['facebook_id']=$attributes['id'];
                unset($attributes['id']);
                unset($attributes['link']);
                break;
            }
            case 'vkontakte':{
                unset($attributes['user_id']);
                unset($attributes['uid']);
                if(isset($attributes['sex']))
                    $attributes['sex']=$attributes['sex']==2?1:0;
                unset($attributes['nickname']);
                unset($attributes['screen_name']);
                if(isset($attributes['bdate']))
                {
                    $attributes['birth_date']=date_create_from_format('d.m.Y', $attributes['bdate'])->format('Y-m-d');
                    unset($attributes['bdate']);
                }
                unset($attributes['city']);//цифра
                unset($attributes['country']);//цифра
                unset($attributes['timezone']);
                if(isset($attributes['photo']))
                    $attributes['photo'];
                $attributes['vkontakte_id']=$attributes['id'];
                unset($attributes['id']);
                break;
            }
            case 'google':{
                unset($attributes['kind']);
                unset($attributes['etag']);
                if(isset($attributes['gender']))
                {
                    $attributes['sex']=$attributes['gender']=='male'?1:0;
                    unset($attributes['gender']);
                }
                if(isset($attributes['emails']))
                {
                    $attributes['email']=$attributes['emails'][0]['value'];
                    unset($attributes['emails']);
                }
                unset($attributes['objectType']);
                unset($attributes['displayName']);
                if(isset($attributes['name']))
                {
                    $attributes['first_name']=$attributes['name']['givenName'];
                    $attributes['last_name']=$attributes['name']['familyName'];
                    unset($attributes['name']);
                }
                unset($attributes['url']);
                $attributes['google_id']=$attributes['id'];
                unset($attributes['id']);
                unset($attributes['isPlusUser']);
                unset($attributes['language']);
                unset($attributes['circledByCount']);
                unset($attributes['verified']);
                if(isset($attributes['image']))
                {
                    $attributes['photo']=$attributes['image']['url'];
                    $attributes['photo'] = str_replace("?sz=50", "", $attributes['photo']);
                    unset($attributes['image']);
                }
                break;
            }
        }
        return $attributes;
    }
    
}