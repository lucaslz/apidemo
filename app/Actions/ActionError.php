<?php

namespace App\Actions;

use JsonSerializable;

class ActionError implements JsonSerializable
{
    const BAD_REQUEST = 'BAD_REQUEST';
    const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    const NOT_ALLOWED = 'NOT_ALLOWED';
    const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    const SERVER_ERROR = 'SERVER_ERROR';
    const UNAUTHENTICATED = 'UNAUTHENTICATED';
    const VALIDATION_ERROR = 'VALIDATION_ERROR';
    const VERIFICATION_ERROR = 'VERIFICATION_ERROR';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @* @param string $type
     * @* @param string $description
     */
    public function __construct($type, $description)
    {
        $this->type = $type;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return self
     */
    public function setDescription(?string $description = null)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => $this->type,
            'description' => $this->description,
        ];
    }
}