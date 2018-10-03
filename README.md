# IP Geo Location

[![Build Status](https://travis-ci.com/Yasir-dev/ip-geolocation.svg?branch=master)](https://travis-ci.com/Yasir-dev/ip-geolocation) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/?branch=master) [![Latest Stable Version](https://poser.pugx.org/yasir-dev/ip-geolocation/v/stable)](https://packagist.org/packages/yasir-dev/ip-geolocation)

Get geo location information based on the IP address of the user. This package uses [Geo IP Api](http://ip-api.com/) to get geo information. Both IPv4 and IPv6 are supported.

![Diagram](https://github.com/Yasir-dev/ip-geolocation/blob/master/geo_ip_diagram.jpg)

## Usage limits

[Geo IP Api](http://ip-api.com/) allows only 150 requests per minute. If you exceed this limit you Ip will be blocked by [Geo IP Api](http://ip-api.com/)

## Installation

You can install the package using composer

```
composer require yasir-dev/ip-geolocation
```

## Usage

```php
// use the package
use ipGeolocation\GeoIPLocation;

// get the location object
$location = (new GeoIPLocation())->getGeoLocation();

//check the status for success
$location->getStatus();

//get the required information
$location->getCountry();
$location->getRegionName();
$location->getRegionCode();
$location->getPostalCode();
$location->getTimezone();
$location->getCurrencyIso();
$location->getCity();
$location->getLongitude();
$location->getLatitude();

//handling error (status fail)
if (!$location->getStatus()) {
    //get error message
    $location->getMessage();
}
```

## Use Cases

* Determine user's location.
* Determine user's currency/language.
* Customise your website based on user's location.

## Contribution

Please feel free to open new issues, pull requests, fork or spread the package

## License

MIT &copy; Yasir Khurshid


