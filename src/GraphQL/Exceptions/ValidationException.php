<?php

namespace Tjventurini\VoyagerCMS\GraphQL\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class ValidationException extends Exception implements RendersErrorsExtensions
{
    /**
     * Validator instance.
     */
    private $validator;

    /**
     * ValidationException
     *
     * @param string $message
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function __construct(string $message, Validator $validator)
    {
        parent::__construct($message);
        $this->validator = $validator;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @return boolean
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing the category of the error.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return 'validation';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return $this->validator->errors()->messages();
    }
}
