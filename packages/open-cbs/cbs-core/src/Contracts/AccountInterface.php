<?php

namespace OpenCbs\CbsCore\Contracts;

interface AccountInterface
{
    public function getId(): string|int;
    public function getAccountNumber(): string;
    public function getCurrency(): string;
    public function isActive(): bool;
}
