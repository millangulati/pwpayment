<?php

/**
 * Description of Key
 *
 * @author vinay
 */
class Key {

    public static function GetPrivateKey($file, $is_file = true, $passphrase = '') {
        return static::GetKey(($is_file) ? static::GetContent($file) : base64_decode($file), 'Private', $passphrase);
    }

    public static function GetPublicKey($file, $is_file = true) {
        return static::GetKey(($is_file) ? static::GetContent($file) : base64_decode($file), 'Public');
    }

    private static function GetKey($content, $type = 'Public', $passphrase = '') {
        if (empty($content)) {
            throw new BadRequestException('You must provide a valid key.');
        }
        $key = FALSE;
        switch (strtolower(trim($type))) {
            case 'public': $key = openssl_pkey_get_public($content);
                break;
            case 'private': $key = openssl_get_privatekey($content, $passphrase);
                break;
            default: throw new BadRequestException('You must provide a valid key type.');
        }
        if ($key === FALSE) {
            throw new BadRequestException('It was not possible to parse your key, reason: ' . openssl_error_string());
        }
        $details = openssl_pkey_get_details($key);
        if (!isset($details['key']) || $details['type'] !== OPENSSL_KEYTYPE_RSA) {
            throw new BadRequestException('This key is not compatible with RSA signatures.');
        }
        return $key;
    }

    private static function GetContent($keyfile) {
        if (!is_readable(__DIR__ . '/' . $keyfile)) {
            throw new BadRequestException('You must provide a valid key file.');
        }
        return file_get_contents(__DIR__ . '/' . $keyfile);
    }

}
