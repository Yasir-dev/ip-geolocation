<?php

namespace ipGeolocation;

/**
 * This class provides information about user's location based on ip address
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */

class Location
{
    /**
     * Status of request
     *
     * @var bool
     */
    private $status;

    /**
     * Information message
     *
     * @var string
     */
    private $message;

    /**
     * City name of the user
     *
     * @var string
     */
    private $city;

    /**
     * Country name of the user
     *
     * @var string
     */
    private $country;

    /**
     * Country code of the user
     *
     * @var string
     */
    private $countryCode;

    /**
     * Latitude of the user
     *
     * @var float
     */
    private $latitude;

    /**
     * Longitude of the user
     *
     * @var float
     */
    private $longitude;

    /**
     * Region Code of the user
     *
     * @var string
     */
    private $regionCode;

    /**
     * Region name of the user
     *
     * @var string
     */
    private $regionName;

    /**
     * Time zone of the user
     *
     * @var string
     */
    private $timezone;

    /**
     * Postal code of the user
     *
     * @var int
     */
    private $postalCode;

    /**
     * Return status
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param bool $status Status
     *
     * @return Location
     */
    public function setStatus(bool $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Return messahe
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message Message
     *
     * @return Location
     */
    public function setMessage(string $message): Location
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Return city name
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set city name
     *
     * @param string $city City name
     *
     * @return Location
     */
    public function setCity(?string $city): Location
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Return coutry name
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set country name
     *
     * @param string $country Country name
     *
     * @return Location
     */
    public function setCountry(?string $country): Location
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Return coutry code
     *
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Set country code
     *
     * @param string $countryCode Country code
     *
     * @return Location
     */
    public function setCountryCode(?string $countryCode): Location
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Return latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Location
     */
    public function setLatitude(?string $latitude): Location
    {
        $this->latitude = (float) $latitude;

        return $this;
    }

    /**
     * Return longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude Longitude
     *
     * @return Location
     */
    public function setLongitude(?string $longitude): Location
    {
        $this->longitude = (float) $longitude;

        return $this;
    }

    /**
     * Return region code
     *
     * @return string
     */
    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    /**
     * Set region code
     *
     * @param string $regionCode Region code
     *
     * @return Location
     */
    public function setRegionCode(?string $regionCode): Location
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    /**
     * Retrun region name
     *
     * @return string
     */
    public function getRegionName(): string
    {
        return $this->regionName;
    }

    /**
     * Set region name
     *
     * @param string $regionName Region name
     *
     * @return Location
     */
    public function setRegionName(?string $regionName): Location
    {
        $this->regionName = $regionName;

        return $this;
    }

    /**
     * Return timezone
     *
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     *
     * @return Location
     */
    public function setTimezone(?string $timezone): Location
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Return postal code
     *
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * Set postal code
     *
     * @param string $postalCode Postal code
     *
     * @return Location
     */
    public function setPostalCode(?string $postalCode): Location
    {
        $this->postalCode = (int) $postalCode;

        return $this;
    }

    /**
     * Return currency Iso code
     *
     * @return string
     */
    public function getCurrencyIso(): string
    {
        return (new Currency())->getCurrencyIso($this->countryCode);
    }
}
