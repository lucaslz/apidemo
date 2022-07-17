<?php

namespace App\Interfaces;

interface ErrorInterface
{
    /**
     * Return status code from error
     * 
     * @return int
     */
    public function getStatusCode();

    /**
     * Return error type
     * 
     * @return string
     */
    public function getType();

    /**
     * Return description of error
     * 
     * @return string
     */
    public function getDescription();
}