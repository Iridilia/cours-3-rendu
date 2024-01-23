<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Product;

class ProductTest extends TestCase
{
    public function testGetName():void {
        $product=new Product('Pomme', ['EUR'=>0.5], 'food');
        $this->assertEquals('Pomme', $product->getName());
    }
    public function testGetPrices():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->assertEquals(['USD'=>0.54,'EUR'=>0.5], $product->getPrices());
    }
    public function testGetType():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->assertEquals('food', $product->getType());
    }
    public function testSetType():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $product->setType('other');
        $this->assertEquals('other', $product->getType());
    }
    public function testSetTypeErrorInvalidType():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid type');
        $product->setType('fruit');
    }
    public function testSetPrices():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $product->setPrices(['USD'=>0.8, 'EUR'=>0.74]);
        $this->assertEquals(['USD'=>0.8, 'EUR'=>0.74], $product->getPrices());
    }
    public function testSetPricesInvalidCurrency():void {
        $product=new Product('Pomme', ['EUR'=>0.5], 'food');
        $product->setPrices(['CNY'=>3.91]);
        $this->assertEquals(['EUR'=>0.5], $product->getPrices());
    }
    public function testSetPricesInvalidPric():void {
        $product=new Product('Pomme', ['EUR'=>0.5], 'food');
        $product->setPrices(['USD'=>-3.5]);
        $this->assertEquals(['EUR'=>0.5], $product->getPrices());
    }
    public function testSetName():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $product->setName('Poire');
        $this->assertEquals('Poire', $product->getName());
    }
    public function testGetTVA():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->assertEquals(0.1, $product->getTVA());
    }
    public function testListCurrencies():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->assertEquals(['USD', 'EUR'], $product->listCurrencies());
    }
    public function testGetPrice():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->assertEquals(0.5, $product->getPrice('EUR'));
    }
    public function testGetPriceErrorInvalidCurrency():void {
        $product=new Product('Pomme', ['USD'=>0.54,'EUR'=>0.5], 'food');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $product->getPrice('CNY');
    }
    public function testGetPriceErrorCurrencyNotAvailable():void {
        $product=new Product('Pomme', ['EUR'=>0.5], 'food');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Currency not available for this product');
        $product->getPrice('USD');
    }
}