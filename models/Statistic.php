<?php

namespace app\models;

use Yii;

class Statistic extends \yii\base\Object
{
    private $userId;
    private $year;
    
    private $moneyInMonths;
    private $balanceInMonths;
    private $moneyInCategories;
    private $moneyInSubcategories;
    private $moneyIn;
    private $moneyOut;
    private $balance;
    private $status;
    
    public function prepareResults($year) {
        $this->userId = Yii::$app->user->identity->id;
        $this->year = $year;
        
        $this->moneyInMonths = $this->prepareMoneyInMonths();
        $this->balanceInMonths = $this->prepareBalanceInMonths();
        $this->moneyInCategories = $this->prepareMoneyInCategories();
        $this->moneyInSubcategories = $this->prepareMoneyInSubcategories();
        $this->moneyIn = $this->prepareMoneyIn();
        $this->moneyOut = $this->prepareMoneyOut();
        
        $this->moneyIn = $this->moneyIn ? $this->moneyIn : 0;
        $this->moneyOut = $this->moneyOut ? $this->moneyOut : 0;
        
        $this->balance = $this->moneyIn - $this->moneyOut;
        $this->status = '';
        if ($this->balance > 0) {
            $this->status = '+';
        }
        else if ($this->balance < 0) {
            $this->status = '-';
        }
        $this->balance = abs($this->balance);
    }
    
    public function getYear() {
        return $this->year;
    }
    
    public function getMoneyInMonths() {
        return $this->moneyInMonths;
    }
    
    public function getBalanceInMonths() {
        return $this->balanceInMonths;
    }
    
    public function getMoneyInCategories() {
        return $this->moneyInCategories;
    }
    
    public function getMoneyInSubcategories() {
        return $this->moneyInSubcategories;
    }
    
    public function getMoneyIn() {
        return $this->moneyIn;
    }
    
    public function getMoneyOut() {
        return $this->moneyOut;
    }
    
    public function getBalance() {
        return $this->balance;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    private function prepareMoneyInMonths()
    {
        $sql = 'SELECT DATE_FORMAT(date, "%m") AS date, SUM(money_out) AS sum_out, SUM(money_in) AS sum_in
                FROM transaction
                WHERE user_id=:user_id AND YEAR(date)=:year
                GROUP BY DATE_FORMAT(date, "%m")
                ORDER BY date';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryAll();
    }
    
    private function prepareBalanceInMonths()
    {
        $sql = 'SELECT DATE_FORMAT(date, "%m") AS date, SUM(money_in) - SUM(money_out) AS balance
                FROM transaction
                WHERE user_id=:user_id AND YEAR(date)=:year
                GROUP BY DATE_FORMAT(date, "%m")
                ORDER BY date';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryAll();
    }
    
    private function prepareMoneyInCategories()
    {
        $sql = 'SELECT c.id AS id, IFNULL(c.name, "Uncategorized") AS name, SUM(t.money_out) AS sum
                FROM category c
                RIGHT JOIN transaction t ON c.id=t.category_id
                WHERE t.user_id=:user_id AND YEAR(t.date)=:year
                GROUP BY c.id
                ORDER BY c.id';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryAll();
    }
    
    private function prepareMoneyInSubcategories()
    {
        $sql = 'SELECT c.id AS cid, s.id AS sid, IFNULL(c.name, "Uncategorized") AS cname, IFNULL(s.name, "Uncategorized") AS sname, SUM(t.money_out) AS sum
                FROM subcategory s
                RIGHT JOIN transaction t ON s.id=t.subcategory_id
                LEFT JOIN category c ON s.category_id=c.id
                WHERE t.user_id=:user_id AND YEAR(t.date)=:year
                GROUP BY s.id
                ORDER BY c.id, s.id;';
                
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryAll();
    }
    
    private function prepareMoneyIn()
    {
        $sql = 'SELECT SUM(money_in) FROM transaction WHERE user_id=:user_id AND YEAR(date)=:year';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryScalar();
    }
    
    private function prepareMoneyOut()
    {
        $sql = 'SELECT SUM(money_out) FROM transaction WHERE user_id=:user_id AND YEAR(date)=:year';
        
        return Yii::$app->db->createCommand($sql)
            ->bindValue(':user_id', $this->userId)
            ->bindValue(':year', $this->year)
            ->queryScalar();
    }
}
