<?php

namespace OpenCbs\CbsCore\Contracts;

interface ImmutableLedger
{
    /**
     * Post a transaction to the ledger.
     * The implementation MUST ensure this is an append-only operation.
     *
     * @param TransactionInterface $transaction
     * @return void
     */
    public function post(TransactionInterface $transaction): void;

    /**
     * Get the balance of an account at a specific point in time.
     *
     * @param AccountInterface $account
     * @param \DateTimeInterface|null $at
     * @return float|int
     */
    public function getBalance(AccountInterface $account, ?\DateTimeInterface $at = null): float|int;

    /**
     * Reverse a transaction. 
     * This MUST create a new contra-entry, not delete the original.
     *
     * @param TransactionInterface $originalTransaction
     * @param string $reason
     * @return TransactionInterface The reversal transaction
     */
    public function reverse(TransactionInterface $originalTransaction, string $reason): TransactionInterface;
}
