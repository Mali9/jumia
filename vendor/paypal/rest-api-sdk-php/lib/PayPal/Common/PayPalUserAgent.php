<?php

namespace PayPal\Common;

/**
 * Class PayPalUserAgent
 * PayPalUserAgent generates User Agent for curl requests
 *
 * @package PayPal\Common
 */
class PayPalUserAgent
{

    /**
     * Returns the value of the User-Agent header
     * Add environment values and php version numbers
     *
     * @param string $sdkName
     * @param string $sdkVersion
     * @return string
     */
    public static function getValue($sdkName, $sdkVersion)
    {
        $featureList = array(
            'platform-ver=' . PHP_VERSION,
            'bit=' . self::_getPHPBit(),
            'os=Linux_3.10.0-1160.21.1.el7.x86_64',
            'machine=x86_64'
        );
        if (defined('OPENSSL_VERSION_TEXT')) {
            $opensslVersion = explode(' ', OPENSSL_VERSION_TEXT);
            $featureList[] = 'crypto-lib-ver=' . $opensslVersion[1];
        }
        if (function_exists('curl_version')) {
            $curlVersion = curl_version();
            $featureList[] = 'curl=' . $curlVersion['version'];
        }
        return sprintf("PayPalSDK/%s %s (%s)", $sdkName, $sdkVersion, implode('; ', $featureList));
    }

    /**
     * Gets PHP Bit version
     *
     * @return int|string
     */
    private static function _getPHPBit()
    {
        switch (PHP_INT_SIZE) {
            case 4:
                return '32';
            case 8:
                return '64';
            default:
                return PHP_INT_SIZE;
        }
    }
}
