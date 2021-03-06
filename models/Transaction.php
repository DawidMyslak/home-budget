<?php

namespace app\models;

use Yii;
use app\models\Keyword;
use app\helpers\CategoriseHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $date
 * @property string $description
 * @property string $money_in
 * @property string $money_out
 * @property string $balance
 * @property string $hash
 * @property integer $user_id
 * @property integer $import_id
 * @property integer $category_id
 * @property integer $subcategory_id
 * @property integer $keyword_id
 *
 * @property User $user
 * @property Import $import 
 * @property Category $category
 * @property Subcategory $subcategory
 * @property Keyword $keyword
 */
class Transaction extends \yii\db\ActiveRecord
{
    private $categorizedCounter; // number of categorized transactions
    protected $result;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['description'], 'required'],
            [['money_in', 'money_out', 'balance'], 'number'],
            [['user_id', 'import_id', 'category_id', 'subcategory_id', 'keyword_id'], 'integer'],
            [['description'], 'string', 'max' => 128, 'min' => '3'],
            [['hash'], 'string', 'max' => 32],
            ['money_in', 'validateMoneyIn', 'skipOnEmpty' => false],
            ['money_out', 'validateMoneyOut', 'skipOnEmpty' => false],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['import_id'], 'exist', 'skipOnError' => true, 'targetClass' => Import::className(), 'targetAttribute' => ['import_id' => 'id']], 
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
            [['keyword_id'], 'exist', 'skipOnError' => true, 'targetClass' => Keyword::className(), 'targetAttribute' => ['keyword_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'description' => 'Description',
            'money_in' => 'Money In',
            'money_out' => 'Money Out',
            'balance' => 'Balance',
            'hash' => 'Hash',
            'user_id' => 'User ID',
            'import_id' => 'Import ID', 
            'category_id' => 'Category ID',
            'subcategory_id' => 'Subcategory ID',
            'keyword_id' => 'Keyword ID',
            'category.name' => 'Category',
            'subcategory.name' => 'Subcategory',
            'formattedDate' => 'Date',
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
     * @return boolean
     */
    public function prepareHash() {
        $this->hash = md5($this->date . $this->description . $this->money_in . $this->money_out);
        return true;
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
    public function getImport() 
    { 
        return $this->hasOne(Import::className(), ['id' => 'import_id']); 
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
    public function getKeyword()
    {
        return $this->hasOne(Keyword::className(), ['id' => 'keyword_id']);
    }
    
    /**
     * @return void
     */
    public function categorise($keyword)
    {
        $this->categorizedCounter = 0;
        
        // all not categorized transactions for currently logged in user
        $transactions = self::findAll([
            'user_id' => Yii::$app->user->identity->id,
            'category_id' => null,
            'subcategory_id' => null,
            'money_in' => null,
        ]);
        
        // categorise by specified keyword
        foreach ($transactions as $transaction) {
            if (CategoriseHelper::match($transaction->description, $keyword->name)) {
                $transaction->category_id = $keyword->category_id;
                $transaction->subcategory_id = $keyword->subcategory_id;
                $transaction->keyword_id = $keyword->id;
                
                if ($transaction->save()) {
                    $this->categorizedCounter++;
                }
            }
        }
        
        $this->result = $this->categorizedCounter . ' transactions categorized.';
    }
    
    /**
     * @return Transaction
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id, 'user_id' => Yii::$app->user->identity->id]);
    }
    
    /**
     * @return string
     */
    public function getResult() {
        return $this->result;
    }
    
    /**
     * @return string
     */
    public function getFormattedDate() {
        if ($date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->date)) {
            return $date->format('Y-m-d');
        }
                    
        return null;
    }
    
    /*
    * Validates Money In
     */
    public function validateMoneyIn($attribute, $params)
    {
        if (empty($this->money_in) && empty($this->money_out)) {
            $this->addError($attribute, 'Money In (or Money Out) cannot be blank.');
        }
    }
    
    /*
    * Validates Money Out
     */
    public function validateMoneyOut($attribute, $params)
    {
        if (!empty($this->money_in) && !empty($this->money_out)) {
            $this->addError($attribute, 'Money Out (or Money In) should be empty.');
        }
    }
}
