<?php

/**
 * JSON Web Token implementation
 * PHP version > 5
 *
 * @category	Authentication
 * @package Authentication_JWT
 * @author Vinay Kumar
 */
class jwt {

    /**
     * List of implemented signing algorithms.
     */
    public static $supported_algs = array(
        'HS256' => array('hash_hmac', 'SHA256'),
        'HS384' => array('hash_hmac', 'SHA384'),
        'HS512' => array('hash_hmac', 'SHA512'),
        'RS256' => array('openssl', 'SHA256'),
        'RS384' => array('openssl', 'SHA384'),
        'RS512' => array('openssl', 'SHA512')
    );

    /**
     * Converts and signs a PHP object or array into a JWT string.
     * @param object|array $payload PHP object or array
     * @param string $key The secret key. If the algorithm used is asymmetric, this is the private key
     * @param string $alg One of the signing algorithm ('HS256', 'HS384', 'HS512', 'RS256', 'RS384', 'RS512').
     * @param mixed $keyId
     * @param array $head An array with header elements to attach
     * @return string A signed JWT
     * @throws BadRequestException
     * @uses JSON::Encode Base64::Encode
     */
    public static function encode($payload, $key, $alg = 'HS256', $keyId = null, $head = null) {
        $header = array('typ' => 'JWT', 'alg' => $alg);
        if ($keyId !== null) {
            $header['kid'] = $keyId;
        }
        if (isset($head) && is_array($head)) {
            $header = array_merge($head, $header);
        }

        $segments = array();
        $segments[] = Base64::Encode(JSON::Encode($header));
        $segments[] = Base64::Encode(JSON::Encode($payload));
        $signing_input = implode('.', $segments);
        $signature = static::sign($signing_input, $key, $alg);
        $segments[] = Base64::Encode($signature);
        return implode('.', $segments);
    }

    /**
     * Decodes a JWT string into a PHP object.
     * @param string $jwt The JWT
     * @param string|array $key The key, or map of keys. If the algorithm used is asymmetric, this is the public key
     * @return object The JWT's payload as a PHP object
     * @uses jsonDecode
     * @throws BadRequestException
     * @uses JSON::Encode Base64::Encode
     */
    public static function decode($jwt, $key, $allowed_algs = array()) {

        if (empty($key)) {
            throw new NotImplementedException('Key may not be empty');
        }
        $allowed_algs = empty($allowed_algs) ? array_keys(static::$supported_algs) : ((array) $allowed_algs);
        $tks = explode('.', $jwt);
        if (count($tks) != 3) {
            throw new BadRequestException('Wrong number of segments');
        }
        list($headb64, $bodyb64, $cryptob64) = $tks;
        if (null === ($header = JSON::Decode(Base64::Decode($headb64)))) {
            throw new BadRequestException('Invalid header encoding');
        }
        if (null === ($payload = JSON::Decode(Base64::Decode($bodyb64)))) {
            throw new BadRequestException('Invalid claims encoding');
        }
        $sig = Base64::Decode($cryptob64);
        if (empty($header->alg)) {
            throw new BadRequestException('Empty algorithm');
        }
        if (empty(static::$supported_algs[$header->alg])) {
            throw new BadRequestException('Algorithm not supported');
        }
        if (!in_array($header->alg, $allowed_algs)) {
            throw new BadRequestException('Algorithm not allowed');
        }
        if (is_array($key) || $key instanceof \ArrayAccess) {
            if (isset($header->kid)) {
                $key = $key[$header->kid];
            } else {
                throw new BadRequestException('"kid" empty, unable to lookup correct key');
            }
        }
        if (!static::verify("$headb64.$bodyb64", $sig, $key, $header->alg)) {
            throw new BadRequestException('Signature verification failed');
        }
        return $payload;
    }

    /**
     * Sign a string with a given key and algorithm.
     * @param string $msg The message to sign
     * @param string|resource $key The secret key
     * @param string $alg One of the signing algorithm ('HS256', 'HS384', 'HS512', 'RS256', 'RS384', 'RS512').
     * @return string An encrypted message
     * @throws BadRequestException Unsupported algorithm was specified
     */
    public static function sign($msg, $key, $alg = 'HS256') {
        list($function, $algorithm) = empty(static::$supported_algs[$alg]) ? array('NA', '') : static::$supported_algs[$alg];
        switch ($function) {
            case 'hash_hmac':
                return hash_hmac($algorithm, $msg, $key, true);
            case 'openssl':
                $signature = '';
                $success = openssl_sign($msg, $signature, $key, $algorithm);
                if (!$success) {
                    throw new BadRequestException("OpenSSL unable to sign data");
                }
                return $signature;
            default :
                throw new BadRequestException($alg . ' Algorithm not supported');
        }
    }

    /**
     * Verify a signature with the message, key and method.
     * @param string $msg The original message (header and body)
     * @param string $signature The original signature
     * @param string|resource $key The secret key
     * @param string $alg The algorithm
     * @return bool
     * @throws BadRequestException Invalid Algorithm
     */
    private static function verify($msg, $signature, $key, $alg) {
        list($function, $algorithm) = empty(static::$supported_algs[$alg]) ? array('NA', '') : static::$supported_algs[$alg];
        switch ($function) {
            case 'openssl':
                $success = openssl_verify($msg, $signature, $key, $algorithm);
                if (!$success) {
                    throw new BadRequestException("OpenSSL unable to verify data: " . openssl_error_string());
                } else {
                    return $signature;
                }
            case 'hash_hmac':
                $hash = hash_hmac($algorithm, $msg, $key, true);
                if (function_exists('hash_equals')) {
                    return hash_equals($signature, $hash);
                } else {
                    return static::verify_hmac_hash($signature, $hash);
                }
            default :
                throw new BadRequestException($alg . ' Algorithm not supported');
        }
    }

    /**
     * Verify Signature and HMAC Hash if hash_equals function not exist.
     * @param string $signature The original signature
     * @param string $hash Calculated HMAC hash
     * @return int
     */
    private static function verify_hmac_hash($signature, $hash) {
        $len = min(static::safeStrlen($signature), static::safeStrlen($hash));
        $status = 0;
        for ($i = 0; $i < $len; $i++) {
            $status |= (ord($signature[$i]) ^ ord($hash[$i]));
        }
        $status |= (static::safeStrlen($signature) ^ static::safeStrlen($hash));
        return ($status === 0);
    }

    /**
     * Get the number of bytes in cryptographic strings.
     * @param string
     * @return int
     */
    private static function safeStrlen($str) {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, '8bit');
        }
        return strlen($str);
    }

}

class JSON {

    /**
     * Encode a PHP object|array into a JSON string.
     * @param $input A PHP object|array
     * @return string JSON representation of the PHP object or array
     * @throws BadRequestException Provided object could not be encoded to valid JSON
     */
    public static function Encode($input) {
        $json = json_encode($input);
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($json === 'null' && $input !== null) {
            throw new BadRequestException('Null result with non-null input');
        }
        return $json;
    }

    /**
     * Decode a JSON string into a PHP object.
     * @param $input JSON string
     * @return object Object representation of JSON string
     * @throws BadRequestException Provided string was invalid JSON
     */
    public static function Decode($input) {
        if (version_compare(PHP_VERSION, '5.4.0', '>=') && !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            $obj = json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            $max_int_length = strlen((string) PHP_INT_MAX) - 1;
            $json_without_bigints = preg_replace('/:\s*(-?\d{' . $max_int_length . ',})/', ': "$1"', $input);
            $obj = json_decode($json_without_bigints);
        }
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($obj === null && $input !== 'null') {
            throw new BadRequestException('Null result with non-null input');
        }
        return $obj;
    }

    /**
     * Helper method to throw a JSON error.
     * @param int $errno An error number from json_last_error()
     * @return void
     */
    private static function handleJsonError($errno) {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
        );
        throw new BadRequestException(isset($messages[$errno]) ? $messages[$errno] : 'Unknown JSON error: ' . $errno);
    }

}

class Base64 {

    /**
     * Encode a string with URL-safe Base64.
     * @param string $input The string you want encoded
     * @return string The base64 encode of what you passed in
     */
    public static function Encode($input) {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * Decode a string with URL-safe Base64.
     * @param string $input A Base64 encoded string
     * @return string A decoded string
     */
    public static function Decode($input) {
        if (strlen($input) % 4) {
            $padlen = 4 - (strlen($input) % 4);
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

}
