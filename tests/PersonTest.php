<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Product;

class PersonTest extends TestCase
{
    public function testGetName(): void
    {
        $person=new Person('Prénom', 'EUR');
        $this->assertEquals('Prénom',$person->getName());
    }
    public function testSetName() : void
    {
        $person=new Person('Prénom', 'EUR');
        $person->setName('Emilie');
        $this->assertEquals('Emilie', $person->getName());
    }
    public function testGetWallet() :void {
        $person=new Person('Prénom', 'EUR');
        $this->assertInstanceOf(Wallet::class, $person->getWallet());
    }
    public function testSetWallet():void {
        $person=new Person('Prénom', 'EUR');
        $person->setWallet(new Wallet('USD'));
        $this->assertInstanceOf(Wallet::class, $person->getWallet());
    }
    public function testHasFund():void {
        $person=new Person('Prénom', 'EUR');
        $this->assertFalse($person->hasFund());
    }
    public function testTransfertFund():void {
        $person1=new Person('Lola', 'EUR');
        $person2=new Person('Emilie', 'EUR');

        $person1->wallet->setBalance(100);
        $person1->transfertFund(40, $person2);
        $this->assertEquals([60.0,40.0], [$person1->wallet->getBalance(),$person2->wallet->getBalance()]);
    }
    public function testTransfertFundErrorInvalidCurrency():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t give money with different currencies');

        $person1=new Person('Lola', 'EUR');
        $person2=new Person('John', 'USD');
        $person1->transfertFund(20, $person2);
    }
    public function testDivideWallet():void {
        $person1=new Person('Lola', 'EUR');
        $person1->wallet->setBalance(33);
        $person2=new Person('Emilie', 'EUR');
        $person3=new Person('Jack', 'EUR');
        $person4=new Person('Richard', 'EUR');
        $persons=[$person2, $person3, $person4];

        $person1->divideWallet($persons);
        $this->assertEquals([0.0,11.0,11.0,11.0], [$person1->wallet->getBalance(),
            $person2->wallet->getBalance(),
            $person3->wallet->getBalance(),
            $person4->wallet->getBalance()]);
    }
    public function testBuyProduct():void {
        $person=new Person('Lola', 'EUR');
        $person->wallet->setBalance(200);
        $product=new Product('Bague', ['USD'=>163.00, 'EUR'=>150.00], 'other');
        $person->buyProduct($product);
        $this->assertEquals(50, $person->wallet->getBalance());
    }
    public function testBuyProductErrorInvalidCurrency():void {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t buy product with this wallet currency');

        $person=new Person('Lola', 'EUR');
        $person->wallet->setBalance(200);
        $product=new Product('Pomme', ['USD'=>1], 'food');
        $person->buyProduct($product);
    }
}
