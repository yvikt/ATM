<?php


namespace Lib;

/**
 * Class Terminal
 * @package Lib
 * Terminal is machine that can only get money from human and put them into the account
 */
class Terminal extends GenericBankMachine
{
    protected array $operations = [
        'put_money'
    ];
}