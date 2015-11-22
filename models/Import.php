<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "import".
 *
 * @property integer $id
 * @property string $file_original_name
 * @property string $file_name
 * @property string $date
 * @property integer $user_id
 * @property integer $bank_id
 *
 * @property User $user
 * @property Bank $bank
 * @property Transaction[] $transactions
 */
class Import extends \yii\db\ActiveRecord
{
    public $file;
    public $path;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_original_name', 'file_name', 'bank_id'], 'required'],
            [['date'], 'safe'],
            [['user_id', 'bank_id'], 'integer'],
            [['file_original_name', 'file_name'], 'string', 'max' => 256],
            [['file'], 'file', 'skipOnEmpty' => false],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }
    
    /**
     * @return array
     */
    private function extensions()
    {
        return ['csv'];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        $this->user_id = Yii::$app->user->identity->id;
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_original_name' => 'File Name',
            'file_name' => 'File Name',
            'date' => 'Date',
            'user_id' => 'User ID',
            'bank_id' => 'Bank',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['import_id' => 'id']);
    }
    
    /**
     * @return Keyword
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id]);
    }
    
    /**
     * @return boolean whether the model passes validation
     */
    public function upload()
    {
        if (!in_array(strtolower($this->file->extension), $this->extensions())) {
            return false;
        }
        
        $this->file_original_name = $this->file->baseName . '.' . $this->file->extension;
        $this->file_name = Yii::$app->user->identity->id . '_' . $this->file->baseName . '_' . time() . '.' . $this->file->extension;
        
        $date = new \DateTime();
        $this->date = $date->format('Y-m-d H:i:s');
            
        if ($this->validate()) {
            $this->path = '../uploads/' . $this->file_name;
            $this->file->saveAs($this->path);
            return true;
        }
        
        return false;
    }
}
