<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\helpers;

use yii\base\Exception;
use Yii;

class Helper
{
    public static $booleanValues=[0=>'No', 1=>'Yes',];

    public static function jsonToArray($data, $defaultValueReturn=[], $exception=true)
    {
        if($data){
            $result = json_decode($data, JSON_FORCE_OBJECT);
            if(is_array($result))
                return $result;
            if($exception)
                throw new Exception("data is wrong json format.");
        }
        return $defaultValueReturn;
    }

    public static function arrayToJson($data, $defaultValueReturn="", $exception=true)
    {
        if($data){
            if(is_array($data)){
                $value=json_encode((object)$data, JSON_UNESCAPED_UNICODE);
                /*
                $value = str_replace( "{", "{\n\t",$value);
                $value = str_replace( ",", ",\n\t",$value);
                $value = str_replace( ":", " : ",$value);
                $value = str_replace( "}", "\n}",$value);
                */
                $value = str_replace( "{", "{\n",$value);
                $value = str_replace( ",", ",\n",$value);
                //$value = str_replace( ":", " : ",$value);
                $value = str_replace( "}", "\n}",$value);
                return $value;
            }
            if($exception)
                throw new Exception("Values is not an array");
        }
        return $defaultValueReturn;
    }

    public static function getId($object)
    {
        $objectID = (new \ReflectionClass($object))->getShortName();
        $objectID = strtolower($objectID);
        return $objectID;
    }


    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        self::rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }elseif(is_file($dir))
            unlink($dir);
    }
    public static function emptydir($dirPath)
    {
        if (! is_dir($dirPath))
            throw new \InvalidArgumentException("$dirPath must be a directory");
        $files = scandir($dirPath, 1);
        foreach ($files as $file){
            if($file=='.gitignore' || $file=='.' || $file=='..')
                continue;
            self::rrmdir($dirPath.'/'.$file);
        }
    }

    public static function copyr($source, $dest)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            self::copyr("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }

    public static function cleanForMatchAgainst($q)
    {
        $q = trim($q);
        $q = strtolower($q);
        $q = substr($q, 0, 64);
        $q = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $q);
        $q = preg_replace('/ {2,}/',' ',$q);
        $q = str_replace(' ','* ',$q);
        if($q)
            $q.="*";
        return $q;
    }
}