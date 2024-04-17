<?php declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpClient\HttpClient;

use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractCurrencyRateProvider implements CurrencyRateProviderInterface
{
    private ?HttpClientInterface $client = null;
    private ?SerializerInterface $serializer = null;

    protected function getClient(): HttpClientInterface
    {
        if (false === $this->client instanceof HttpClientInterface) {
            $this->client = HttpClient::create();
        }

        return $this->client;
    }

    protected function getSerializer(): SerializerInterface
    {
        if (false === $this->serializer instanceof SerializerInterface) {
            $phpDocExtractor = new PhpDocExtractor();
            $typeExtractor = new PropertyInfoExtractor(
                typeExtractors: [
                    new ConstructorExtractor([$phpDocExtractor]),
                    $phpDocExtractor,
                ]
            );

            $this->serializer = new Serializer(
                normalizers: [
                    new ObjectNormalizer(propertyTypeExtractor: $typeExtractor),
                    new ArrayDenormalizer(),
                ],
                encoders: [
                    'json' => new JsonEncoder(),
                ]
            );
        }

        return $this->serializer;
    }
}
