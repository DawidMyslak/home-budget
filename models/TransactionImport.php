<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Transaction;
use app\models\Keyword;
use app\helpers\CategoriseHelper;

class TransactionImport extends Transaction
{
    private $importedCounter;
    private $categorizedCounter;
    private $result;
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public static function getTypes() {
        return [
            1 => [
                'id' => 1,
                'name' => 'Bank of Ireland',
                'dateFormat' => 'd/m/Y',
                'fields' => ['date', 'description', 'money_out', 'money_in', 'balance']
            ],
            2 => [
                'id' => 2,
                'name' => 'Permanent TSB',
                'dateFormat' => 'd-M-y',
                'fields' => ['date', 'description', 'money_in', 'money_out', 'balance']
            ]
        ];
    }
    
    public function import($path, $type)
    {
        $this->importedCounter = 0;
        $this->categorizedCounter = 0;        
        
        // all existing transactions for currently logged in user
        $transactions = Transaction::findAll(['user_id' => Yii::$app->user->identity->id]);
        
        // build an array containing transcation hashes
        $hashes = [];
        foreach ($transactions as $transaction) {
            $hashes[] = $transaction->hash;
        }
        
        // categorise helper object
        $categoriseHelper = new CategoriseHelper();
        $categoriseHelper->prepareKeywords();
        
        // get config for current file type
        $types = self::getTypes();
        $type = $types[$type];
        
        // skip first line in the file
        $skipHeader = true;
        
        if (($handle = fopen($path, 'r')) !== false) { // open file
            while (($data = fgetcsv($handle, 1024, ',')) !== false) { // read line
                if (!$skipHeader) {
                    // create an empty transaction object
                    $transaction = new Transaction();
                    
                    // populate object fields using config order
                    $fields = $type['fields'];
                    for ($i = 0; $i < count($fields); $i++) {
                        $transaction[$fields[$i]] = $data[$i];
                    }
                    
                    // format date using config format
                    if ($date = \DateTime::createFromFormat($type['dateFormat'], $transaction->date)) {
                        $transaction->date = $date->format('Y-m-d');
                    }
                    
                    // prepare transcation hash and check if already exists in hash array, if does then do not save this transaction
                    $hash = Transaction::prepareHash($transaction->date, $transaction->description, $transaction->money_in, $transaction->money_out);
                    if (!in_array($hash, $hashes)) {
                        $hashes[] = $hash;
                        $transaction->hash = $hash;
                        
                        // categorise only expenses
                        if (!empty($transaction->money_out)) {
                            // find keyword for description
                            $keyword = $categoriseHelper->search($transaction->description);
                            if ($keyword !== null) {
                                $transaction->category_id = $keyword->category_id;
                                $transaction->subcategory_id = $keyword->subcategory_id;
                                $transaction->keyword_id = $keyword->id;
                                
                                $this->categorizedCounter++; 
                            }
                        }
                        
                        $this->importedCounter++;
                        $transaction->save();
                    }
                }
                $skipHeader = false;
            }
            fclose($handle);
        }
        
        $this->result = $this->importedCounter . ' transactions imported and ' . $this->categorizedCounter . ' categorized.';
    }
    
    public function getResult() {
        return $this->result;
    }
}
