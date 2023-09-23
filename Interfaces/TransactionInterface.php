<?php
//Methods for transaction class to implement (includes two small select queries to get appropriate data for further manipulation)
interface TransactionInterface{

    public function completeTransaction():void;
    public function renderTransaction():void;//Sending proper data to user mail
    public static function pendingTransactionsRender(array $transactionData):void;
    public static function finishedTransactionsRender(array $transactionData):void;
    public static function finishedTransactionsDelete(array $transactionData):void;
    public static function updateTransactionStatusFinished():void;
    public static function updateTransactionStatusPending():void;
    public static function deletedTransactionRestore(array $transactionData):void;
    
}