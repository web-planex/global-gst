<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    //protected $connection = 'new_db';
    const ACCOUNT_TYPE_CURRENT_ASSETS = 1;
    const ACCOUNT_TYPE_BANK = 2;
    const ACCOUNT_TYPE_CREDIT_CARD = 3;

    public static $account_type = [
        self::ACCOUNT_TYPE_CURRENT_ASSETS => 'Current assets',
        self::ACCOUNT_TYPE_BANK => 'Bank',
        self::ACCOUNT_TYPE_CREDIT_CARD => 'Credit Card',
    ];

    const ALLOWANCE_FOR_BAD_DEBTS = 1;
    const ASSETS_AVAILABLE_FOR_SALE = 2;
    const BALANCE_WITH_GOVERNMENT_AUTHORITIES = 3;
    const DEVELOPMENT_COSTS = 4;
    const EMPLOYEE_CASH_ADVANCES = 5;
    const INVENTORY = 6;
    const INVESTMENTS_OTHER = 7;
    const LOANS_TO_OFFICERS = 8;
    const LOANS_TO_OTHERS = 9;
    const LOANS_TO_SHAREHOLDERS = 10;
    const OTHER_CURRENT_ASSETS = 11;
    const PREPAID_EXPENSES = 12;
    const RETAINAGE = 13;
    const SHORT_TERM_INVESTMENTS_IN_RELATED_PARTIES = 14;
    const SHORT_TERM_LOANS_AND_ADVANCES_TO_RELATED_PARTIES = 15;
    const UNDEPOSITED_FUNDS = 16;

    public static $current_assets = [
        self::ALLOWANCE_FOR_BAD_DEBTS => 'Allowance for bad debts',
        self::ASSETS_AVAILABLE_FOR_SALE => 'Assets available for sale',
        self::BALANCE_WITH_GOVERNMENT_AUTHORITIES => 'Balance with Government Authorities',
        self::DEVELOPMENT_COSTS => 'Development costs',
        self::EMPLOYEE_CASH_ADVANCES => 'Employee cash advances',
        self::INVENTORY => 'Inventory',
        self::INVESTMENTS_OTHER => 'Investments - Other',
        self::LOANS_TO_OFFICERS => 'Loans to officers',
        self::LOANS_TO_OTHERS => 'Loans to others',
        self::LOANS_TO_SHAREHOLDERS => 'Loans to Shareholders',
        self::OTHER_CURRENT_ASSETS => 'Other current assets',
        self::PREPAID_EXPENSES => 'Prepaid expenses',
        self::RETAINAGE => 'Retainage',
        self::SHORT_TERM_INVESTMENTS_IN_RELATED_PARTIES => 'Short Term Investments in Related Parties',
        self::SHORT_TERM_LOANS_AND_ADVANCES_TO_RELATED_PARTIES => 'Short Term Loans and Advances to related parties',
        self::UNDEPOSITED_FUNDS => 'Undeposited funds'
    ];

    const CASH_AND_CASH_EQUIVALENTS = 1;
    const CASH_ON_HAND = 2;
    const CLIENT_TRUST_ACCOUNTS = 3;
    const CURRENT = 4;
    const MONEY_MARKET = 5;
    const OTHER_EARMARKED_BANK_ACCOUNTS = 6;
    const RENTS_HELD_IN_TRUST = 7;
    const SAVINGS = 8;

    public static $bank = [
        self::CASH_AND_CASH_EQUIVALENTS => 'Cash and Cash Equivalents',
        self::CASH_ON_HAND => 'Cash on hand',
        self::CLIENT_TRUST_ACCOUNTS => 'Client trust accounts',
        self::CURRENT => 'Current',
        self::MONEY_MARKET => 'Money market',
        self::OTHER_EARMARKED_BANK_ACCOUNTS => 'Other Earmarked Bank Accounts',
        self::RENTS_HELD_IN_TRUST => 'Rents held in trust',
        self::SAVINGS => 'Savings'
    ];

    const CREDIT_CARD = 1;

    public static $credit_card = [
        self::CREDIT_CARD => 'Credit card'
    ];
}
