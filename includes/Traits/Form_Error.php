<?php 
namespace ADS\Traits;

/**
 * Trait Form_Error
 *
 * A trait for handling form errors and validation.
 *
 * @package FrontendFormSubmission
 */
trait Form_Error {
    /**
     * Holds the validation errors.
     *
     * @var array
     */
    public $errors = [];

    /**
     * Check if a specific error exists for a given key.
     *
     * @param string $key The error key to check.
     *
     * @return bool True if the error exists, false otherwise.
     */
    public function has_error( $key ) {
        return isset( $key ) ? $this->errors[ $key ] : false;
    }

    /**
     * Get the error message for a specific key.
     *
     * @param string $key The error key to retrieve the message for.
     *
     * @return mixed|string The error message if it exists, or an empty string if not found.
     */
    public function get_error( $key ) {
        if ( isset( $this->errors[ $key ] ) ) {
            return $this->errors[ $key ];
        }

        return false;
    }
}
