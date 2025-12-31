<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected int $status;
    protected string $codeName;
    protected array $details;

    public function __construct(string $message,int $status = 400,string $codeName = 'API_ERROR',array $details = []) {
        parent::__construct($message);
        $this->status   = $status;
        $this->codeName = $codeName;
        $this->details  = $details;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function codeName(): string
    {
        return $this->codeName;
    }

    public function details(): array
    {
        return $this->details;
    }
}
