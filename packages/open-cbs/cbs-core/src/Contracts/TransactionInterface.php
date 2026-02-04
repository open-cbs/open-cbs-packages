<?php

namespace OpenCbs\CbsCore\Contracts;

interface TransactionInterface
{
    public function getId(): string|int;
    public function getAmount(): float|int;
    public function getCurrency(): string;
    public function getDebitAccount(): AccountInterface;
    public function getCreditAccount(): AccountInterface;
    public function getPostedAt(): \DateTimeInterface;
    public function getReference(): ?string;
    public function getDescription(): string;
}
