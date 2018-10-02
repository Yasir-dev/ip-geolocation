<?php

namespace ipGeolocation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * This class gets geo location information from ip address
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class GeoIPLocation
{
    /**
     * Indices for getting user IP Address
     *
     * @var array
     */
    private $remotes = array(
        'REMOTE_ADDR',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
    );

    /**
     * Return geo location data based on the user's Ip Address
     *
     * Example: ip-address => {"status": "success", "country": "COUNTRY", "countryCode": "COUNTRY CODE", "region": "REGION CODE"}
     *
     * @return Location
     */
    public function getGeoLocation()
    {
        try {
            $response = (new Client())->get(
                $this->getRequestUrl($this->getIpAddress()),
                $this->getRequestOptions()
            );

            if (\in_array($response->getStatusCode(), range(200, 299))) {

                return $this->getMappedLocation($response);
            }

            return $this->handleError($this->getResponsePhrase($response));

        } catch (RequestException $e) {

            return $this->handleError($e->getMessage());
        }
    }

    /**
     * Return Ip address of the user
     *
     * @return string
     */
    public function getIpAddress(): string
    {
        foreach ($this->remotes as $remote) {
            if ($address = $_SERVER[$remote]) {
                foreach (explode(',', $address) as $ipAddress) {
                    if ($this->isIpAddressValid($ipAddress)) {
                        return $ipAddress;
                    }
                }
            }
        }

        return ApiConfig::DEFAULT_IP_ADDRESS;
    }

    /**
     * Check if ip address is valid or not
     *
     * @param string $ipAddress Ip Address
     *
     * @return bool
     */
    public function isIpAddressValid(string $ipAddress): bool
    {
        if (\filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }

        return false;
    }

    /**
     * Return request Url
     *
     * @param string $ipAddress Ip Address
     *
     * @return string
     */
    private function getRequestUrl(string $ipAddress): string
    {
        return \sprintf(
            '%s/%s/%s',
            ApiConfig::IP_API_BASE_URL,
            ApiConfig::RESPONSE_FORMAT,
            $ipAddress
        );
    }

    /**
     * Return options array for http request
     *
     * @return array
     */
    private function getRequestOptions(): array
    {
        return array(
            'timeout' => ApiConfig::TIMEOUT,
            'connect_timeout' => ApiConfig::CONNECTION_TIMEOUT,
            'headers' => null,
        );
    }

    /**
     * Return mapped Location Object
     *
     * @param ResponseInterface $response Response
     *
     * @return Location
     */
    private function getMappedLocation(ResponseInterface $response): Location
    {
        $data = \json_decode($response->getBody());

        return (new Location())
            ->setStatus($this->getStatus($data->status))
            ->setMessage($data->message)
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

    /**
     * Return status
     *
     * @param string $status Status string
     *
     * @return bool
     */
    private function getStatus(string $status): bool
    {
        return ('success' === $status ? true : false);
    }

    /**
     * Return response phrase with corresponding http status code
     *
     * @param ResponseInterface $response Response
     *
     * @return string
     */
    private function getResponsePhrase(ResponseInterface $response): string
    {
        return \sprintf(
            'Request failed with response code: %d and response: %s',
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
    }

    /**
     * Handle error
     *
     * @param string $message Message
     *
     * @return Location
     */
    private function handleError(string $message): Location
    {
        return (new Location())
            ->setStatus(false)
            ->setMessage($message);
    }
}