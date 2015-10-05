<?php

namespace app\models;

use Yii;
use app\models\Subcategory;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 *
 * @property User $user
 * @property Keyword[] $keywords
 * @property Subcategory[] $subcategories
 * @property Transaction[] $transactions
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
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
            'user_id' => 'User ID',
        ];
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
    public function beforeDelete() {
        Subcategory::deleteAll(['category_id' => $this->id]);
        return parent::beforeDelete();
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
    public function getKeywords()
    {
        return $this->hasMany(Keyword::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['category_id' => 'id']);
    }
    
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id]);
    }
    
    public static function getAll() {
        return self::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->orWhere(['user_id' => null])
            ->all();
    }
    
    public static function getStructure() {
        return self::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->orWhere(['user_id' => null])
            ->with(['subcategories' => function($query) {
                $query
                    ->where(['user_id' => Yii::$app->user->identity->id])
                    ->orWhere(['user_id' => null]);
            }])
            ->asArray()
            ->all();
    }
}
