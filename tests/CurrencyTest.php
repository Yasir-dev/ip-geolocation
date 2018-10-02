<?php

namespace ipGeolocation\tests;

use ipGeolocation\Currency;
use PHPUnit\Framework\TestCase;

/**
 * Tests for CurrencyTest class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class CurrencyTest extends TestCase
{
    public function testGetCurrencyIso()
    {
        $this->assertSame('EUR', (new Currency())->getCurrencyIso('DE'));
        $this->assertSame('USD', (new Currency())->getCurrencyIso('US'));
        $this->assertEmpty((new Currency())->getCurrencyIso('FooBAR'));
    }
}