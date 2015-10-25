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
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    /**
     * @return array
     */
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
    
    /**
     * @return void
     */
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
        
        // prepare keywords
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
                    
                    // prepare transcation hash and check if already exists in the hash array, if does then do not save this transaction
                    $transaction->prepareHash();
                    if (!in_array($transaction->hash, $hashes)) {
                        $hashes[] = $transaction->hash;
                        
                        // categorise only expenses
                        if (!empty($transaction->money_out)) {
                            // find keyword for transaction description
                            $keyword = $categoriseHelper->search($transaction->description);
                            if ($keyword !== null) {
                                $transaction->category_id = $keyword->category_id;
                                $transaction->subcategory_id = $keyword->subcategory_id;
                                $transaction->keyword_id = $keyword->id;
                            }
                        }
                        
                        if ($transaction->save()) {
                            $this->importedCounter++;
                            
                            if ($transaction->category_id) {
                                $this->categorizedCounter++;
                            }
                        }
                    }
                }
                $skipHeader = false;
            }
            fclose($handle);
        }
        
        $this->result = $this->importedCounter . ' transactions imported, ' . $this->categorizedCounter . ' categorized.';
    }
}
