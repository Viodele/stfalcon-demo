<?php declare(strict_types=1);

namespace App\Service;

final class Notifier
{
    public function push(string $message): void
    {
        echo "$message\n";
    }
}
