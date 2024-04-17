<?php declare(strict_types=1);

namespace App\Provider\Monobank;

use App\Provider\AbstractCurrencyRateProvider;
use App\Provider\Monobank\DTO\MonobankRate;
use App\ValueObject\CurrencyRate;
use LogicException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class Monobank extends AbstractCurrencyRateProvider
{
    public const NAME = 'monobank';
    private const DATA_SOURCE_URL = 'https://api.monobank.ua/bank/currency';

    /**
     * @throws TransportExceptionInterface
     */
    public function fetchRates(string $baseCurrencyCode, array $currencyCodes): array
    {
        $rawResponse = $this->getRawResponse();

        $rates = [];
        foreach ($rawResponse as $item) {
            if (
                $baseCurrencyCode !== CurrencyDictionary::getIsoCode($item->getCurrencyCodeB())
                || false === in_array(
                    CurrencyDictionary::getIsoCode($item->getCurrencyCodeA()),
                    $currencyCodes,
                    true
                )
                || null === $item->getRateBuy()
                || null === $item->getRateSell()
            ) {
                continue;
            }
            $rates[] = (new CurrencyRate())
                ->setProvider(self::NAME)
                ->setCurrency(CurrencyDictionary::getIsoCode($item->getCurrencyCodeA()))
                ->setRateBuy($item->getRateBuy())
                ->setRateSell($item->getRateSell());
        }

        return $rates;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientException
     * @throws LogicException
     *
     * @return MonobankRate[]
     */
    private function getRawResponse(): array
    {
        $response = $this->getClient()->request(
            Request::METHOD_GET,
            self::DATA_SOURCE_URL
        );

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            // TODO: Make customized exception for third-party data providers
            throw new ClientException($response);
        }

        try {
            return $this->getSerializer()->deserialize(
                $response->getContent(),
                sprintf('%s[]', MonobankRate::class),
                'json'
            );
        } catch (Throwable $e) {
            throw new LogicException('Unable to parse response', 0, $e);
        }
    }
}
