<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\Topic;

class m151006_103205_add_file_to_topics extends Migration
{
    public function up()
    {
        $aDir = $this->getDirSruct();

        foreach($aDir as $v) {
            $sDir = $v['path'];
            if( !is_dir($sDir) && !mkdir($sDir, 0777) ) {
                echo "Can't create {$v['title']}: {$sDir}\n";
                return false;
            }
            else {
                echo "Create {$v['title']}: {$sDir}\n";
            }
        }
    }

    public function down()
    {
        $aDir = $this->getDirSruct();
        foreach($aDir as $v) {
            $sDir = $v['path'];
            $this->removeDir($sDir);
        }
        return true;
    }

    public function getUploadDir() {
//        $sDocRoot = $_SERVER['DOCUMENT_ROOT'];
        $sDocRoot = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web';
        $sDir = $sDocRoot . DIRECTORY_SEPARATOR . Topic::UPLOAD_PATH;
        return $sDir;
    }

    public function getDirSruct() {
        $sDir = $this->getUploadDir();
        $aDir = [
            [
                'path' => $sDir,
                'title' => 'upload dir',
            ],
            [
                'path' => $sDir . DIRECTORY_SEPARATOR . Topic::UPLOAD_IMG_PATH,
                'title' => 'upload image dir',
            ],
            [
                'path' => $sDir . DIRECTORY_SEPARATOR . Topic::UPLOAD_FILE_PATH,
                'title' => 'upload file dir',
            ],
        ];
        return $aDir;
    }

    public function removeDir($sDir) {
        if( is_dir($sDir) ) {
            if( $hd = opendir($sDir) ) {
                while( false !== ($fn = readdir($hd)) ) {
                    if( ($fn == '.') || ($fn == '..') ) {
                        continue;
                    }

                    $sName = $sDir . DIRECTORY_SEPARATOR . $fn;

                    if( is_dir($sName) ) {
                        $this->removeDir($sName);
                    }
                    else {
                        unlink($sName);
                    }
                }
                closedir($hd);
            }
            rmdir($sDir);
        }
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
