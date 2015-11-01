<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property integer $id
 * @property string $name
 * @property string $file_fields
 * @property string $file_date_format
 * @property integer $user_id
 *
 * @property User $user
 * @property Import[] $imports
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'file_fields', 'file_date_format'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['file_fields'], 'string', 'max' => 256],
            [['file_date_format'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'file_fields' => 'File Fields',
            'file_date_format' => 'File Date Format',
            'user_id' => 'User ID',
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
    public function getImports()
    {
        return $this->hasMany(Import::className(), ['bank_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getAll() {
        return self::find()
            ->all();
    }
}
