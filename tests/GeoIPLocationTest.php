<?php

namespace ipGeolocation\tests;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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
    /**
     * Success response
     *
     * @var array
     */
    private $responseSuccess = array (
        'status' => 'success',
        'country' => 'Germany',
        'countryCode' => 'DE',
        'region' => 'NW',
        'regionName' => 'North Rhine-Westphalia',
        'city' => 'Wesseling',
        'zip' => '50389',
        'lat' => '50.8271',
        'lon' => '6.9747',
        'timezone' => 'Europe/Berlin',
    );

    /**
     * Fail response
     *
     * @var array
     */
    private $responseFail = array (
        'status' => 'fail',
        'message' => 'reserved range',
    );

    /**
     * Test for getGeoLocation method
     */
    public function testGetGeoLocation()
    {
        $_SERVER['REMOTE_ADDR'] = '188.110.9.8';

        $location = $this->getMock($this->responseSuccess)->getGeoLocation();

        $this->assertInstanceOf('ipGeolocation\Location', $location);
        $this->assertTrue($location->getStatus());
        $this->assertSame('Germany', $location->getCountry());
        $this->assertSame('Wesseling', $location->getCity());
        $this->assertSame('DE', $location->getCountryCode());
        $this->assertSame(50.8271, $location->getLatitude());
        $this->assertSame(6.9747, $location->getLongitude());
        $this->assertSame('NW', $location->getRegionCode());
        $this->assertSame('North Rhine-Westphalia', $location->getRegionName());
        $this->assertSame('Europe/Berlin', $location->getTimezone());
        $this->assertSame(50389, $location->getPostalCode());
        $this->assertSame('EUR', $location->getCurrencyIso());
    }

    /**
     * Fail test case for getGeoLocation
     */
    public function testGetGeoLocationFail()
    {
        $_SERVER['REMOTE_ADDR'] = '';
        $location = $this->getMock($this->responseFail)->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('reserved range', $location->getMessage());
    }

    /**
     * Test case for invalid Ip Address
     */
    public function testGetGeoLocationIpInvalid()
    {
        $_SERVER['REMOTE_ADDR'] = '188.11098';
        $geoIp = $this->getMock($this->responseFail);
        $location = $geoIp->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('reserved range', $location->getMessage());
        $this->assertSame('127.0.0.1', $geoIp->getIpAddress());
    }

    /**
     * Test case for invalid request
     */
    public function testRequestInvalid()
    {
        $location = $this->getMockRequestException()->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('Client error: 400', $location->getMessage());
    }

    /**
     * Test case for invalid response
     */
    public function testResponseInvalid()
    {
        $location = $this->getMock(array(), 500)->getGeoLocation();

        $this->assertFalse($location->getStatus());
        $this->assertSame('Request failed with response code: 500 and response: Internal Server Error', $location->getMessage());
    }

    /**
     * Get mocked object to avoid live api requests
     *
     * @param array $response Response
     * @param int $statusCode       Http status code
     *
     * @return GeoIPLocation
     */
    private function getMock(array $response = array(), int $statusCode = 200): GeoIPLocation
    {
       $mock = new MockHandler(array(
            new Response($statusCode, [], \json_encode($response), '1.1', ''),
            new RequestException('Client error: 400', new Request('GET', 'test'))
        ));

        return (new GeoIPLocation())->setMockHandler($mock);
    }

    /**
     * Get mock object for exception to test edge error case
     *
     * @return GeoIPLocation
     */
    private function getMockRequestException()
    {
        $mock = new MockHandler(array(
            new RequestException('Client error: 400', new Request('GET', 'test'))
        ));

        return (new GeoIPLocation())->setMockHandler($mock);
    }
}
