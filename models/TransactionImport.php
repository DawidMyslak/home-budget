<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Transaction;
use app\models\Keyword;
use app\helpers\CategoriseHelper;

class TransactionImport extends Transaction
{
    const BANK_OF_IRELAND = 'bankOfIreland';
    const PERMANENT_TSB = 'permanentTsb';
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    private static function types()
    {
        return [
            'bankOfIreland' => [
                'dateFormat' => 'd/m/Y',
                'fields' => ['date', 'description', 'money_out', 'money_in', 'balance']
            ],
            'permanentTsb' => [
                'dateFormat' => 'dd/mm/yyyy',
                'fields' => ['date', 'description', 'money_in', 'money_out', 'balance']
            ]
        ];
    }
    
    public static function import($path, $type)
    {
        // all existing transactions for currently logged in user
        $transactions = Transaction::findAll(['user_id' => Yii::$app->user->identity->id]);
        
        // build an array containing transcation hashes
        $hashes = [];
        foreach ($transactions as $transcation) {
            $hashes[] = $transcation->hash;
        }
        
        // categorise helper object
        $categoriseHelper = new CategoriseHelper();
        $categoriseHelper->prepareKeywords();
        
        // get config for current file type
        $type = self::types()[$type];
        
        // skip first line in the file
        $skipHeader = true;
        
        if (($handle = fopen($path, 'r')) !== false) { // open file
            while (($data = fgetcsv($handle, 1024, ',')) !== false) { // read line
                if (!$skipHeader) {
                    // create an empty transaction object
                    $transcation = new Transaction();
                    
                    // populate object fields using config order
                    $fields = $type['fields'];
                    for ($i = 0; $i < count($fields); $i++) {
                        $transcation[$fields[$i]] = $data[$i];
                    }
                    
                    // format date using config format
                    $transcation->date = \DateTime::createFromFormat($type['dateFormat'], $transcation->date)->format('Y-m-d');
                    
                    // prepare transcation hash and check if already exists in hash array, if does then do not save this transaction
                    $hash = Transaction::prepareHash($transcation->date, $transcation->description, $transcation->money_in, $transcation->money_out, $transcation->balance);
                    if (!in_array($hash, $hashes)) {
                        $transcation->hash = $hash;
                        
                        // categorise only expenses
                        if (!empty($transcation->money_out)) {
                            // find keyword for description
                            $keyword = $categoriseHelper->search($transcation->description);
                            if ($keyword !== null) {
                                $transcation->category_id = $keyword->category_id;
                                $transcation->subcategory_id = $keyword->subcategory_id;
                                $transcation->keyword_id = $keyword->id;
                            }
                        }
                        
                        $transcation->save();
                    }
                }
                $skipHeader = false;
            }
            fclose($handle);
        }
    }
}
