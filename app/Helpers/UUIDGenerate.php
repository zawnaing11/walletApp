<?php
namespace App\Helpers;

use App\Wallet;
use App\Transaction;

class UUIDGenerate {

    public static function accountNumber()
    {
        $account = mt_rand(0000000000000000, 9999999999999999);
        if (Wallet::where('account_number', $account)->exists()) {
            self::accountNumber();
        }
        return $account;
    }

    public static function trsId()
    {
        $trsId = mt_rand(0000000000000000, 9999999999999999);
        if (Transaction::where('trs_id', $trsId)->exists()) {
            self::trsId();
        }
        return $trsId;
    }

    public static function refNo()
    {
        $refNo = mt_rand(0000000000000000, 9999999999999999);
        if (Transaction::where('ref_no', $refNo)->exists()) {
            self::refNo();
        }
        return $refNo;
    }
}

?>