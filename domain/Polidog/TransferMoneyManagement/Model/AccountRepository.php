<?php declare(strict_types=1);

namespace Polidog\TransferMoneyManagement\Model;



interface AccountRepository
{
    public function findAccount(string $number): Account;

    public function create(Account $account);

    public function delete(Account $account);

    public function transferSave(Account $source, Account $destination, History $history);
}