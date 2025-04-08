<?php

class NotEnoughBalanceException extends Exception { 
}
class TooLargeDepositException extends Exception { 
}



class BankAccount{
    public $saldo;

    function __construct(){
        $this->saldo = 0;
    }

    function deposit($amount){
        $this->saldo = $this->saldo + $amount;
    }
    function withdraw($amount){
        if($amount > $this->saldo){
            throw new NotEnoughBalanceException("Belopp större än saldo");
        } 
        if($amount > 3000){
            throw new TooLargeDepositException("Belopp större än 3 000 kr");
        }
        $this->saldo = $this->saldo - $amount;

    }
};

$bankAccount = new BankAccount();
$bankAccount->deposit(5000);
try{    
    $bankAccount->withdraw(6000);
} catch (NotEnoughBalanceException $e) {
    echo "Inte tillräckligt med pengar på kontot!";
} catch (TooLargeDepositException $e) {
    echo "För stort belopp!";
} catch (Exception $e) {
    echo "Något annat fel inträffade!";
} 

var_dump($bankAccount->saldo); 

?>
