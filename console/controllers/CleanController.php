<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use user\models\User;
use user\models\Token;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class CleanController extends Controller
{
    public function actionTest()
    {
        Yii::$app->mailer->compose()
            ->setTo(['nurbek.nurjanov@mail.ru'=>'Nurbek Nurjanov'])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject('Тест сообщение '.date('Y-m-d H:i:s'))
            ->setHtmlBody('Тест сообщение')
            ->send();
    }

    public function actionChmod()
    {
        $dir = Yii::getAlias('@app').'/..';//console dir
        exec("chmod -R 777 $dir/");
    }


    public function actionIndex()
    {
        /*$empty = [
            'frontend/web/assets',
            'frontend/runtime',
            //'upload',
            //'tmpUpload',
            'backend/web/assets',
            'backend/runtime',
        ];
        foreach ($empty as $dir){
            $this->recursiveChmod($dir);
            $this->emptyDir($dir);
        }*/

        $dir = Yii::getAlias('@app').'/..';//console dir
        exec("rm -R $dir/backend/runtime/*");
        exec("rm -R $dir/console/runtime/*");
        exec("rm -R $dir/frontend/runtime/*");
        exec("rm -R $dir/tests/_output/*");

        exec("rm -R $dir/landing/web/assets/*");
        exec("rm -R $dir/backend/web/assets/*");
        exec("rm -R $dir/frontend/web/assets/*");
        echo "cleaned!\n";
    }
    private function isSakuraBranch()
    {
        return !is_file('/var/www/bangtracker/assets.php');
    }
    public function actionExportFromBang()
    {
        $this->actionIndex();
        $dir = Yii::getAlias('@app').'/..';
        if($this->isSakuraBranch())
            exec("rsync -av --progress * $dir/../sakura --exclude='/vendor' --exclude .git --exclude .idea --exclude frontend/web/upload");
        else
            throw new Exception("Not sakura branch");
    }
    public function actionExportToBang()
    {
        $this->actionIndex();
        $dir = Yii::getAlias('@app').'/..';
        if($this->isSakuraBranch())
            exec("rsync -av --progress * $dir/../bangtracker --exclude='/vendor' --exclude .git --exclude .idea --exclude frontend/web/upload");
        else
            throw new Exception("Not sakura branch");
    }


    //php yii clean/export --folder=123
    //php yii clean/export --folder 123
    public $folder;
    public $exclude=['/vendor', '.git', '.idea', 'frontend/web/upload'];
    public function options($actionID)
    {
        $options = parent::options($actionID);
        $options[] = 'folder';
        return $options;
    }
    //php yii clean/export -f=123
    //php yii clean/export -f 123
    public function optionAliases()
    {
        return ['f' => 'folder'];
    }
    //php yii clean/export ../sakura_production landing
    public function actionExport($folder, $exclude='')
    {
        if($exclude)
            $this->exclude[]=$exclude;

        $this->exclude = ArrayHelper::map($this->exclude, function($key){return $key; }, function($value){ return "--exclude='$value'"; });
        $this->exclude = implode(' ', $this->exclude);


        $this->actionIndex();
        //$dir = Yii::getAlias('@app').'/..';
        //$this->folder;
        $dir = dirname(dirname(__DIR__));

        $dir = $dir.'/'.$folder;

        $command = "rsync -av --progress * $dir $this->exclude";
        if($this->confirm("Are you sure to run \n".$command."\n ? ")){
            if(is_dir($dir))
                exec($command);
            else
                throw new Exception($dir." is not directory");
        }
    }
    //                exec("rsync -av --progress * $dir --exclude='/vendor' --exclude .git --exclude .idea --exclude frontend/web/upload");
    public function confirm($message, $default = false)
    {
        return Console::confirm($message, $default);
    }







    public function emptyDir($dirPath)
    {
        if (! is_dir($dirPath))
            throw new \InvalidArgumentException("$dirPath must be a directory");
        $files = scandir($dirPath, 1);
        foreach ($files as $file){
            if($file=='.gitignore' || $file=='.' || $file=='..')
                continue;
            $this->deleteDir($dirPath.'/'.$file);
        }
    }
    public function deleteDir($dirPath)
    {
        if (! is_dir($dirPath))
            throw new \InvalidArgumentException("$dirPath must be a directory");

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/')
            $dirPath .= '/';

        $files = glob($dirPath . '*', GLOB_MARK);

        foreach ($files as $file)
        {
            if($file=='.gitignore')
                continue;
            if (is_dir($file))
                self::deleteDir($file);
            else
                unlink($file);

        }
        rmdir($dirPath);
    }

    public function recursiveChmod ($path, $filePerm=0777, $dirPerm=0777) {
        // Check if the path exists
        if (!file_exists($path)) {
            return(false);
        }

        // See whether this is a file
        if (is_file($path)) {
            // Chmod the file with our given filepermissions
            chmod($path, $filePerm);

            // If this is a directory...
        } elseif (is_dir($path)) {
            // Then get an array of the contents
            $foldersAndFiles = scandir($path);

            // Remove "." and ".." from the list
            $entries = array_slice($foldersAndFiles, 2);

            // Parse every result...
            foreach ($entries as $entry) {
                // And call this function again recursively, with the same permissions
                $this->recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
            }

            // When we are done with the contents of the directory, we chmod the directory itself
            chmod($path, $dirPerm);
        }

        // Everything seemed to work out well, return true
        return(true);
    }
}