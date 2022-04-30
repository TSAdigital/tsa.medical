<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    public $file_name;
    public $file_dir;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'maxSize' => 10*(1024*1024), 'extensions' => '7z, zip, pdf', 'tooBig' => 'Превышен максимально допустимый размер (объём) файла в 10 Мб'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs($this->file_dir .  $this->file_name . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Файл',
        ];
    }
}
