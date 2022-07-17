<?php

namespace App\Actions;

use JsonSerializable;
use App\Actions\ActionError;

class ActionPayload implements JsonSerializable
{
    private $statusCode;

    /**
     * @var array|object|null
     */
    private $data;

    /**
     * @var ActionError
     */
    private $error;

    public function __construct(
        $statusCode = 200,
        $data = null,
        $error = null
    ) {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array|null|object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return ActionError
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return JsonSerializable
     */
    public function jsonSerialize()
    {
        $payload = [
            'statusCode' => $this->statusCode,
        ];

        if ($this->data !== null) {
            $payload['data'] = $this->data;
        } elseif ($this->error !== null) {
            $payload['error'] = $this->error;
        }

        return $payload;
    }
}