<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Wallet;

class WalletTest extends TestCase
{
    public function testGetBalance():void {
        $wallet=new Wallet('EUR');
        $this->assertEquals(0, $wallet->getBalance());
    }
    public function testGetCurrency():void {
        $wallet=new Wallet('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }
    public function testSetBalance():void {
        $wallet=new Wallet('EUR');
        $wallet->setBalance(50.0);
        $this->assertEquals(50.0, $wallet->getBalance());
    }
    public function testSetBalanceErrorInvalidBalance():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid balance');

        $wallet=new Wallet('EUR');
        $wallet->setBalance(-30.0);
    }
    public function testSetCurrency():void {
        $wallet=new Wallet('EUR');
        $wallet->setCurrency('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }
    public function testSetCurrencyErrorInvalidCurrency():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');

        $wallet=new Wallet('EUR');
        $wallet->setCurrency('CNY');
    }
    public function testRemoveFund():void {
        $wallet=new Wallet('EUR');
        $wallet->setBalance(50);
        $wallet->removeFund(20);
        $this->assertEquals(30,$wallet->getBalance());
    }
    public function testRemoveFundErrorInvalidAmount():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');

        $wallet=new Wallet('EUR');
        $wallet->removeFund(-10);
    }
    public function testRemoveFundErrorInsufficientFunds():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');

        $wallet=new Wallet('EUR');
        $wallet->removeFund(10);
    }
    public function testAddFunds():void {
        $wallet=new Wallet('EUR');
        $wallet->addFund(10);
        $this->assertEquals(10, $wallet->getBalance());
    }
    public function testAddFundsErrorInvalidAmount():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');

        $wallet=new Wallet('EUR');
        $wallet->addFund(-10);
    }
}