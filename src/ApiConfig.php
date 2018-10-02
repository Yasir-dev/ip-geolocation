<?php

namespace ipGeolocation;

/**
 * IP API configuration
 *
 * PHP version 7
 *
 * @author yasir khurshid <yasir.khurshid@gmail.com>
 */
class ApiConfig
{
    /**
     * Base Url of Ip Api
     */
    const IP_API_BASE_URL = 'http://ip-api.com';

    /**
     * Data format for response
     */
    const RESPONSE_FORMAT = 'json';

    /**
     * Default Ip address
     */
    const DEFAULT_IP_ADDRESS = '127.0.0.1';

    /**
     * Timeout if the client fails to connect to the server in 10 seconds.
     */
    const CONNECTION_TIMEOUT = 1;

    /**
     * Timeout if a server does not return a response in 10 seconds.
     */
    const TIMEOUT = 1;
}
