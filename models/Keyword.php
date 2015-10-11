<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "keyword".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $subcategory_id
 *
 * @property User $user
 * @property Category $category
 * @property Subcategory $subcategory
 * @property Transaction[] $transactions
 */
class Keyword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'category_id', 'subcategory_id'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
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
            'category_id' => 'Category ID',
            'subcategory_id' => 'Subcategory ID',
            'category.name' => 'Category',
            'subcategory.name' => 'Subcategory',
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['keyword_id' => 'id']);
    }
    
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id]);
    }
    
    public function getPossibleKeywords()
    {
        $sql = 'SELECT description AS name, COUNT(description) AS count FROM transaction
                WHERE user_id=:user_id AND category_id IS NULL AND subcategory_id IS NULL AND money_out IS NOT NULL
                GROUP BY description
                HAVING count >= 2
                ORDER BY count DESC
                LIMIT 10';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', Yii::$app->user->identity->id)
            ->queryAll();
    }
}
