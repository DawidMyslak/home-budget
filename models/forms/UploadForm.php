<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $file;
    public $path;
    public $type;

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, /*'extensions' => 'csv'*/],
            [['type'], 'integer'],
        ];
    }

    /**
     * @return boolean whether the model passes validation
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->path = '../uploads/' . Yii::$app->user->identity->id . '_' . $this->file->baseName . '_' . time() . '.' . $this->file->extension;
            $this->file->saveAs($this->path);
            return true;
        }
        
        return false;
    }
}