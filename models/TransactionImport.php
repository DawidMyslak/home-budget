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
     * @return void
     */
    public function import($import)
    {
        $path = $import->path;
        $bank = $import->bank;
        
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
        
        // skip first line in the file
        $skipHeader = true;
        
        if (($handle = fopen($path, 'r')) !== false) { // open file
            while (($data = fgetcsv($handle, 1024, ',')) !== false) { // read line
                if (!$skipHeader) {
                    // create an empty transaction object
                    $transaction = new Transaction();
                    $transaction->import_id = $import->id;
                    
                    // populate object fields using config order
                    $fields = explode(',', $bank->file_fields);
                    for ($i = 0; $i < count($fields); $i++) {
                        if (isset($data[$i])) {
                            $transaction[$fields[$i]] = $data[$i];
                        }
                    }
                    
                    // format date using config format
                    if ($date = \DateTime::createFromFormat($bank->file_date_format, $transaction->date)) {
                        $transaction->date = $date->format('Y-m-d');
                    }
                    else {
                        $transaction->date = null;
                    }
                    
                    // prepare transcation hash and check if already exists in the hash array, if does then do not save this transaction
                    if ($transaction->prepareHash() && !in_array($transaction->hash, $hashes)) {
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
