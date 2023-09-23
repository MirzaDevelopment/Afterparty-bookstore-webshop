<?php
//Methods for transaction class to implement (SELECT queries to get transaction info)
interface TransactionSelectInterface{

    public function selectAllTransactions():void;
    public static function selectSearchTransactions(mixed $user_input):void;
    public function selectDeletedTransactions():void;
    
}