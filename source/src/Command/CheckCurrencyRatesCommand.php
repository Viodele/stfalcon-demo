<?php declare(strict_types=1);

namespace App\Command;

use App\Service\CurrencyRateExporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'currency:rates:check',
    description: 'Checks currency rates using Monobank and PrivatBank API services.'
)]
final class CheckCurrencyRatesCommand extends Command
{
    const PROCESSABLE_CURRENCY_CODES = ['USD', 'EUR'];
    const BASE_CURRENCY_CODE = 'UAH';

    public function __construct(
        private readonly CurrencyRateExporter $currencyRateExporter,
        private readonly ?string $name = null
    ) {
        parent::__construct($this->name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->currencyRateExporter->export(
            self::BASE_CURRENCY_CODE,
            self::PROCESSABLE_CURRENCY_CODES
        );

        return Command::SUCCESS;
    }
}
