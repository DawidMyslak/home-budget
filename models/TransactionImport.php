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
        $categoriseHelper = new CategoriseHelper();
        $categoriseHelper->prepareKeywords();
        
        $type = TransactionImport::types()[$type];
        $skipHeader = true;
        
        if (($handle = fopen($path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1024, ',')) !== false) {
                if (!$skipHeader) {
                    $transcation = new Transaction();
                    
                    $fields = $type['fields'];
                    for ($i = 0; $i < count($fields); $i++) {
                        $transcation[$fields[$i]] = $data[$i];
                    }
                    
                    $keyword = $categoriseHelper->search($transcation->description);
                    if ($keyword !== null) {
                        $transcation->category_id = $keyword->category_id;
                        $transcation->subcategory_id = $keyword->subcategory_id;
                        $transcation->keyword_id = $keyword->id;
                    }
                    
                    $transcation->date = \DateTime::createFromFormat($type['dateFormat'], $transcation->date)->format('Y-m-d');
                    $transcation->save();
                }
                $skipHeader = false;
            }
            fclose($handle);
        }
    }
}
