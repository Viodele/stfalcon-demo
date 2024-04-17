<?php declare(strict_types=1);

namespace App\Provider\PrivatBank;

use App\Provider\AbstractCurrencyRateProvider;
use App\Provider\PrivatBank\DTO\PrivatBankRate;
use App\ValueObject\CurrencyRate;
use LogicException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class PrivatBank extends AbstractCurrencyRateProvider
{
    public const NAME = 'privatbank';
    private const DATA_SOURCE_URL = 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11';

    /**
     * @throws TransportExceptionInterface
     */
    public function fetchRates(string $baseCurrencyCode, array $currencyCodes): array
    {
        $rawResponse = $this->getRawResponse();

        $rates = [];
        foreach ($rawResponse as $item) {
            if (
                $baseCurrencyCode !== $item->getBaseCcy()
                || false === in_array($item->getCcy(), $currencyCodes, true)
                || $item->getBuy() <= 0
                || $item->getSale() <= 0
            ) {
                continue;
            }
            $rates[] = (new CurrencyRate())
                ->setProvider(self::NAME)
                ->setCurrency($item->getCcy())
                ->setRateBuy($item->getBuy())
                ->setRateSell($item->getSale());
        }

        return $rates;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientException
     * @throws LogicException
     *
     * @return PrivatBankRate[]
     */
    private function getRawResponse(): array
    {
        $response = $this->getClient()->request(
            Request::METHOD_GET,
            self::DATA_SOURCE_URL
        );

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new ClientException($response);
        }

        try {
            return $this->getSerializer()->deserialize(
                $response->getContent(),
                sprintf('%s[]', PrivatBankRate::class),
                'json'
            );
        } catch (Throwable $e) {
            throw new LogicException('Unable to parse response', 0, $e);
        }
    }
}
