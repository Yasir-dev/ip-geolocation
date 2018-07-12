<?php

namespace yasir\ipgeolocation;

/**
 * This class gets geo location information from ip address
 *
 * @author  Yasir Khurshid <yasirkhurshid@hotmail.com>
 * @version 1.0
 */

class GeoIPLocation
{

    const IP_API_BASE_URL = 'http://ip-api.com';

    const RESPONSE_FORMAT = 'json';

    const DEFAULT_IP = '127.0.0.1';

    /**
     * @var array
     */
    private $remotes = array(
        'HTTP_X_FORWARDED_FOR',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
        'HTTP_X_CLUSTER_CLIENT_IP',
    );

    /**
     * @return Location
     */
    public function getGeoLocation()
    {
        $ip = $this->getIp();
        $url = $this->getRequestUrl($ip);

        $curl = curl_init();

        // Set options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            \CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)',
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HEADER => 0,
            CURLINFO_HEADER_OUT => 0,
            CURLOPT_VERBOSE => 1,
            CURLOPT_CUSTOMREQUEST, 'GET'
        ]);


        $response = curl_exec($curl);

        $data = \json_decode($response);

        return $this->getMappedLocation($data);
    }

    /**
     * @return string
     */
    public function getIp()
    {
        foreach ($this->remotes as $remote) {
            if ($address = $_SERVER[$remote]) {
                foreach (explode(',', $address) as $ip) {
                    if ($this->isIpValid($ip)) {
                        return $ip;
                    }
                }
            }
        }

        return self::DEFAULT_IP;
    }

    /**
     *
     * @param $ip
     *
     * @return bool
     */
    public function isIpValid($ip)
    {
        if (\filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }

        return false;
    }

    /**
     * @param $ip
     *
     * @return string
     */
    private function getRequestUrl($ip)
    {
        return \sprintf(
            '%s/%s/%s',
            self::IP_API_BASE_URL,
            self::RESPONSE_FORMAT,
            $ip
        );
    }

    /**
     * @param $data
     *
     * @return Location
     */
    private function getMappedLocation($data)
    {
        return (new Location())
            ->setStatus($data->status)
            ->setCity($data->city)
            ->setCountry($data->country)
            ->setCountryCode($data->countryCode)
            ->setLatitude($data->lat)
            ->setLongitude($data->lon)
            ->setRegionCode($data->region)
            ->setRegionName($data->regionName)
            ->setTimezone($data->timezone)
            ->setPostalCode($data->zip);
    }
}



