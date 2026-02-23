<?php
/**
 * Crypto Utilities Class
 *
 * Provides encryption, decryption, password generation, and HMAC signing
 * utilities for the BFLUXCO theme. Consolidated from BFLUXCO_Client_Access
 * and BFLUXCO_Case_Study_Passwords classes.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Crypto_Utils
 *
 * Centralized cryptographic utilities for the BFLUXCO theme.
 *
 * Usage:
 * ```php
 * // Encrypt/Decrypt data
 * $encrypted = BFLUXCO_Crypto_Utils::encrypt( array( 'user_id' => 123 ) );
 * $decrypted = BFLUXCO_Crypto_Utils::decrypt( $encrypted );
 *
 * // Generate secure password
 * $password = BFLUXCO_Crypto_Utils::generate_password( 16 );
 *
 * // Sign data with HMAC
 * $signature = BFLUXCO_Crypto_Utils::sign_data( $data );
 * $is_valid = BFLUXCO_Crypto_Utils::verify_signature( $data, $signature );
 * ```
 *
 * @since 1.0.0
 */
class BFLUXCO_Crypto_Utils {

    /**
     * Encryption algorithm.
     *
     * @var string
     */
    const CIPHER_ALGO = 'AES-256-CBC';

    /**
     * IV length for AES-256-CBC.
     *
     * @var int
     */
    const IV_LENGTH = 16;

    /**
     * Default password length.
     *
     * @var int
     */
    const DEFAULT_PASSWORD_LENGTH = 12;

    /**
     * Minimum password length.
     *
     * @var int
     */
    const MIN_PASSWORD_LENGTH = 8;

    /**
     * Maximum password length.
     *
     * @var int
     */
    const MAX_PASSWORD_LENGTH = 32;

    /**
     * Characters used for password generation.
     * Excludes easily confused characters (0, O, l, 1, I).
     *
     * @var string
     */
    const PASSWORD_CHARS = 'abcdefghjkmnpqrstuvwxyz23456789';

    /**
     * Characters for strong passwords (includes uppercase and symbols).
     *
     * @var string
     */
    const STRONG_PASSWORD_CHARS = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789!@#$%^&*';

    /**
     * Get encryption key.
     *
     * Uses BFLUXCO_ENCRYPTION_KEY constant if defined, otherwise falls back
     * to WordPress auth salt with a theme-specific suffix.
     *
     * @since 1.0.0
     *
     * @param string $context Optional context for key derivation. Default 'default'.
     * @return string The encryption key.
     */
    public static function get_encryption_key( $context = 'default' ) {
        if ( defined( 'BFLUXCO_ENCRYPTION_KEY' ) && ! empty( BFLUXCO_ENCRYPTION_KEY ) ) {
            $base_key = BFLUXCO_ENCRYPTION_KEY;
        } else {
            $base_key = wp_salt( 'auth' );
        }

        // Derive context-specific key using SHA-256.
        return hash( 'sha256', $base_key . 'bfluxco_' . $context );
    }

    /**
     * Encrypt data.
     *
     * Encrypts data using AES-256-CBC with a random IV.
     * The IV is prepended to the encrypted data and both are base64 encoded.
     *
     * @since 1.0.0
     *
     * @param mixed  $data    Data to encrypt. Arrays/objects are JSON encoded.
     * @param string $context Optional context for key derivation. Default 'default'.
     * @return string|false Base64 encoded encrypted string, or false on failure.
     */
    public static function encrypt( $data, $context = 'default' ) {
        // Handle non-string data.
        if ( ! is_string( $data ) ) {
            $data = wp_json_encode( $data );
            if ( false === $data ) {
                return false;
            }
        }

        $key = self::get_encryption_key( $context );

        // Generate random IV.
        try {
            $iv = random_bytes( self::IV_LENGTH );
        } catch ( Exception $e ) {
            return false;
        }

        // Encrypt the data.
        $encrypted = openssl_encrypt(
            $data,
            self::CIPHER_ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ( false === $encrypted ) {
            return false;
        }

        // Prepend IV and encode.
        return base64_encode( $iv . $encrypted );
    }

    /**
     * Decrypt data.
     *
     * Decrypts data encrypted with the encrypt() method.
     *
     * @since 1.0.0
     *
     * @param string $encrypted Base64 encoded encrypted string.
     * @param string $context   Optional context for key derivation. Default 'default'.
     * @param bool   $as_array  Whether to decode JSON result as array. Default true.
     * @return mixed Decrypted data, or false on failure.
     */
    public static function decrypt( $encrypted, $context = 'default', $as_array = true ) {
        if ( empty( $encrypted ) || ! is_string( $encrypted ) ) {
            return false;
        }

        $key = self::get_encryption_key( $context );

        // Decode base64.
        $data = base64_decode( $encrypted, true );
        if ( false === $data || strlen( $data ) < self::IV_LENGTH ) {
            return false;
        }

        // Extract IV and encrypted data.
        $iv = substr( $data, 0, self::IV_LENGTH );
        $encrypted_data = substr( $data, self::IV_LENGTH );

        // Decrypt.
        $decrypted = openssl_decrypt(
            $encrypted_data,
            self::CIPHER_ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ( false === $decrypted ) {
            return false;
        }

        // Try to decode JSON.
        $json_decoded = json_decode( $decrypted, $as_array );
        if ( null !== $json_decoded || 'null' === $decrypted ) {
            return $json_decoded;
        }

        // Return as plain string if not JSON.
        return $decrypted;
    }

    /**
     * Generate a secure random password.
     *
     * Generates a password using cryptographically secure random bytes.
     * Excludes easily confused characters by default.
     *
     * @since 1.0.0
     *
     * @param int  $length Optional. Password length. Default 12.
     * @param bool $strong Optional. Include uppercase and symbols. Default false.
     * @return string Generated password.
     */
    public static function generate_password( $length = null, $strong = false ) {
        // Validate and constrain length.
        if ( null === $length ) {
            $length = self::DEFAULT_PASSWORD_LENGTH;
        }
        $length = max( self::MIN_PASSWORD_LENGTH, min( self::MAX_PASSWORD_LENGTH, absint( $length ) ) );

        // Choose character set.
        $chars = $strong ? self::STRONG_PASSWORD_CHARS : self::PASSWORD_CHARS;
        $chars_length = strlen( $chars );

        $password = '';

        for ( $i = 0; $i < $length; $i++ ) {
            try {
                $index = random_int( 0, $chars_length - 1 );
            } catch ( Exception $e ) {
                // Fallback to mt_rand if random_int fails (should never happen).
                $index = wp_rand( 0, $chars_length - 1 );
            }
            $password .= $chars[ $index ];
        }

        return $password;
    }

    /**
     * Generate a memorable password.
     *
     * Creates a password from random words separated by a delimiter.
     * Easier to remember but still secure.
     *
     * @since 1.0.0
     *
     * @param int    $word_count Optional. Number of words. Default 4.
     * @param string $separator  Optional. Word separator. Default '-'.
     * @return string Generated password.
     */
    public static function generate_memorable_password( $word_count = 4, $separator = '-' ) {
        $word_count = max( 3, min( 6, absint( $word_count ) ) );

        // Simple word list for memorable passwords.
        $words = array(
            'alpha', 'beta', 'gamma', 'delta', 'echo', 'foxtrot',
            'gulf', 'hotel', 'india', 'juliet', 'kilo', 'lima',
            'mike', 'november', 'oscar', 'papa', 'quebec', 'romeo',
            'sierra', 'tango', 'uniform', 'victor', 'whiskey', 'xray',
            'yankee', 'zulu', 'arrow', 'bridge', 'cloud', 'dusk',
            'ember', 'flame', 'grove', 'harbor', 'island', 'jasper',
            'knight', 'lantern', 'meadow', 'north', 'ocean', 'peak',
            'quartz', 'river', 'stone', 'thunder', 'unity', 'valley',
        );

        $word_count_available = count( $words );
        $selected = array();

        for ( $i = 0; $i < $word_count; $i++ ) {
            try {
                $index = random_int( 0, $word_count_available - 1 );
            } catch ( Exception $e ) {
                $index = wp_rand( 0, $word_count_available - 1 );
            }
            $selected[] = $words[ $index ];
        }

        // Add a random number at the end for extra entropy.
        try {
            $number = random_int( 10, 99 );
        } catch ( Exception $e ) {
            $number = wp_rand( 10, 99 );
        }

        return implode( $separator, $selected ) . $separator . $number;
    }

    /**
     * Sign data with HMAC.
     *
     * Creates an HMAC-SHA256 signature for the given data.
     *
     * @since 1.0.0
     *
     * @param mixed  $data    Data to sign. Arrays/objects are JSON encoded.
     * @param string $context Optional context for key derivation. Default 'signing'.
     * @return string HMAC signature.
     */
    public static function sign_data( $data, $context = 'signing' ) {
        // Convert non-string data to JSON.
        if ( ! is_string( $data ) ) {
            $data = wp_json_encode( $data );
        }

        $key = self::get_signing_key( $context );

        return hash_hmac( 'sha256', $data, $key );
    }

    /**
     * Verify HMAC signature.
     *
     * Verifies that the signature matches the data using timing-safe comparison.
     *
     * @since 1.0.0
     *
     * @param mixed  $data      Data that was signed.
     * @param string $signature The signature to verify.
     * @param string $context   Optional context for key derivation. Default 'signing'.
     * @return bool True if signature is valid, false otherwise.
     */
    public static function verify_signature( $data, $signature, $context = 'signing' ) {
        $expected = self::sign_data( $data, $context );

        return hash_equals( $expected, $signature );
    }

    /**
     * Get signing key for HMAC operations.
     *
     * Uses a separate key derivation for signing operations.
     *
     * @since 1.0.0
     *
     * @param string $context Optional context for key derivation. Default 'signing'.
     * @return string The signing key.
     */
    public static function get_signing_key( $context = 'signing' ) {
        if ( defined( 'BFLUXCO_SIGNING_KEY' ) && ! empty( BFLUXCO_SIGNING_KEY ) ) {
            $base_key = BFLUXCO_SIGNING_KEY;
        } else {
            $base_key = wp_salt( 'secure_auth' );
        }

        return hash( 'sha256', $base_key . 'bfluxco_hmac_' . $context );
    }

    /**
     * Hash a password.
     *
     * Uses bcrypt with a configurable cost factor.
     *
     * @since 1.0.0
     *
     * @param string $password Plain text password.
     * @param int    $cost     Optional. Bcrypt cost factor. Default 12.
     * @return string|false Hashed password or false on failure.
     */
    public static function hash_password( $password, $cost = 12 ) {
        $cost = max( 10, min( 14, absint( $cost ) ) );

        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            array( 'cost' => $cost )
        );
    }

    /**
     * Verify a password against its hash.
     *
     * @since 1.0.0
     *
     * @param string $password Plain text password.
     * @param string $hash     Password hash.
     * @return bool True if password matches, false otherwise.
     */
    public static function verify_password( $password, $hash ) {
        return password_verify( $password, $hash );
    }

    /**
     * Generate a secure token.
     *
     * Creates a cryptographically secure random token.
     *
     * @since 1.0.0
     *
     * @param int $length Optional. Token length in bytes. Default 32.
     * @return string Hex-encoded token.
     */
    public static function generate_token( $length = 32 ) {
        $length = max( 16, min( 64, absint( $length ) ) );

        try {
            $bytes = random_bytes( $length );
        } catch ( Exception $e ) {
            // Fallback using WordPress function.
            return wp_generate_password( $length * 2, false );
        }

        return bin2hex( $bytes );
    }

    /**
     * Generate a UUID v4.
     *
     * Creates a random UUID for unique identifiers.
     *
     * @since 1.0.0
     *
     * @return string UUID v4 string.
     */
    public static function generate_uuid() {
        return wp_generate_uuid4();
    }

    /**
     * Create a time-limited token.
     *
     * Generates a token that includes an expiration timestamp.
     *
     * @since 1.0.0
     *
     * @param string $data    Data to include in token.
     * @param int    $expires Expiration time in seconds from now.
     * @return string Signed, encoded token.
     */
    public static function create_timed_token( $data, $expires = 3600 ) {
        $payload = array(
            'data'    => $data,
            'expires' => time() + absint( $expires ),
        );

        $signature = self::sign_data( $payload );
        $payload['sig'] = $signature;

        return self::encrypt( $payload, 'timed_token' );
    }

    /**
     * Validate a time-limited token.
     *
     * Decrypts and verifies a timed token, checking expiration.
     *
     * @since 1.0.0
     *
     * @param string $token The token to validate.
     * @return mixed Token data if valid, false otherwise.
     */
    public static function validate_timed_token( $token ) {
        $payload = self::decrypt( $token, 'timed_token' );

        if ( ! is_array( $payload ) ) {
            return false;
        }

        // Check required fields.
        if ( ! isset( $payload['data'], $payload['expires'], $payload['sig'] ) ) {
            return false;
        }

        // Check expiration.
        if ( $payload['expires'] < time() ) {
            return false;
        }

        // Verify signature.
        $sig = $payload['sig'];
        unset( $payload['sig'] );

        if ( ! self::verify_signature( $payload, $sig ) ) {
            return false;
        }

        return $payload['data'];
    }

    /**
     * Securely erase sensitive data from memory.
     *
     * Attempts to overwrite sensitive string data in memory.
     * Note: PHP's garbage collection may still leave copies.
     *
     * @since 1.0.0
     *
     * @param string $data Reference to sensitive data to erase.
     * @return void
     */
    public static function secure_erase( &$data ) {
        if ( is_string( $data ) ) {
            $length = strlen( $data );
            $data = str_repeat( "\0", $length );
            unset( $data );
        }
    }
}
