# IP Geo Location

Get geo location information from IP address

[![Build Status](https://travis-ci.com/Yasir-dev/ip-geolocation.svg?branch=master)](https://travis-ci.com/Yasir-dev/ip-geolocation) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Yasir-dev/ip-geolocation/?branch=master)

Get geo location information based on the IP address of the user. This package uses [Geo IP Api](http://ip-api.com/) to get geo information. Both IPv4 and IPv6 are supported.

## Usage limits

[Geo IP Api](http://ip-api.com/) allows only 150 requests per minute. If you exceed this limit you Ip will be blocked by [Geo IP Api](http://ip-api.com/)

# Installation

You can install the package using composer

```
composer require yasir-dev/ip-geolocation
```
