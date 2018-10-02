<?php

namespace ipGeolocation\tests;

use ipGeolocation\GeoIPLocation;
use PHPUnit\Framework\TestCase;

/**
 * Tests for GeoIPLocation class
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class GeoIPLocationTest extends TestCase
{
    public function testGetGeoLocation()
    {
        $_SERVER['REMOTE_ADDR'] = '188.110.9.8';
        $location = (new GeoIPLocation())->getGeoLocation();

        $this->assertInstanceOf('ipGeolocation\Location', $location);

        $this->assertTrue($location->getStatus());
        $this->assertSame('Wesseling', $location->getCity());
        $this->assertSame('Germany', $location->getCountry());
        $this->assertSame('DE', $location->getCountryCode());
        $this->assertSame(50.8271, $location->getLatitude());
        $this->assertSame(6.9747, $location->getLongitude());
        $this->assertSame('NW', $location->getRegionCode());
        $this->assertSame('North Rhine-Westphalia', $location->getRegionName());
        $this->assertSame('Europe/Berlin', $location->getTimezone());
        $this->assertSame(50389, $location->getPostalCode());
        $this->assertSame('EUR', $location->getCurrencyIso());
    }

    public function testGetGeoLocationFail()
    {
        $_SERVER['REMOTE_ADDR'] = '';
        $location = (new GeoIPLocation())->getGeoLocation();

        $this->assertInstanceOf('ipGeolocation\Location', $location);

        $this->assertFalse($location->getStatus());
        $this->assertSame('reserved range', $location->getMessage());
    }

    public function testGetGeoLocationIpInvalid()
    {
        $_SERVER['REMOTE_ADDR'] = '188.11098';
        $geoIp = new GeoIPLocation();
        $location = $geoIp->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('reserved range', $location->getMessage());
        $this->assertSame('127.0.0.1', $geoIp->getIpAddress());
    }

    public function testRequestInvalid()
    {
        $stub = $this->getMockBuilder('ipGeolocation\GeoIPLocation')
            ->setMethods(array('getRequestUrl'))
            ->getMock();

        $stub->method('getRequestUrl')
            ->with()
            ->willReturn('http://httpbin.org/status/undefined');


        $location = $stub->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('Client error: 400', $location->getMessage());
    }

    public function testResponseInvalid()
    {
        $stub = $this->getMockBuilder('ipGeolocation\GeoIPLocation')
            ->setMethods(array('getRequestUrl'))
            ->getMock();

        $stub->method('getRequestUrl')
            ->with()
            ->willReturn('http://httpbin.org/status/300');

        $location = $stub->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('Request failed with response code: 300 and response: Multiple Choices', $location->getMessage());
    }
}
