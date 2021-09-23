<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Cron;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Api\ElogicForecastRepositoryInterface;
use Elogic\Forecast\Model\Config\ForecastConfig;
use Elogic\Forecast\Model\ElogicForecast;
use Elogic\Forecast\Model\ElogicForecastFactory;
use Exception;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class UpdateForecast
 *
 * Cron - updates weather forecast
 */
class UpdateForecast
{
    /**
     * @var Curl
     */
    private Curl $curlClient;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var ElogicForecastFactory
     */
    private ElogicForecastFactory $modelFactory;

    /**
     * @var ElogicForecastRepositoryInterface
     */
    private ElogicForecastRepositoryInterface $elogicForecastRepository;

    /**
     * @var ForecastConfig
     */
    private ForecastConfig $forecastConfig;

    /**
     * @param SerializerInterface $serializer
     * @param Curl $curl
     * @param ForecastConfig $forecastConfig
     * @param ElogicForecastRepositoryInterface $elogicForecastRepository
     * @param ElogicForecastFactory $modelFactory
     */
    public function __construct(
        SerializerInterface $serializer,
        Curl $curl,
        ForecastConfig $forecastConfig,
        ElogicForecastRepositoryInterface $elogicForecastRepository,
        ElogicForecastFactory $modelFactory
    ) {
        $this->serializer = $serializer;
        $this->curlClient = $curl;
        $this->forecastConfig = $forecastConfig;
        $this->elogicForecastRepository = $elogicForecastRepository;
        $this->modelFactory = $modelFactory;
    }

    /**
     * @return string
     */
    private function getRequestApiUrl(): string
    {
        $configApiUrl = $this->forecastConfig->getApiUrl();
        $queryParamsArray = [
            'id' => $this->forecastConfig->getCityId(),
            'exclude' => 'hourly,daily',
            'appid' => $this->forecastConfig->getApiKey(),
            'units' => $this->forecastConfig->getUnits()
        ];
        $queryParamsString = http_build_query($queryParamsArray);

        return $configApiUrl . '?' . $queryParamsString;
    }

    /**
     * @return $this|string
     */
    public function execute()
    {
        if (!$this->forecastConfig->getIsEnabled()) {
            return $this;
        }

        try {
            $apiUrl = $this->getRequestApiUrl();
            $this->curlClient->get($apiUrl);
            $response = $this->serializer->unserialize($this->curlClient->getBody());
            if ($response['cod'] ?? 0 === 200) {
                /** @var ElogicForecast $elogicForecast */
                $elogicForecast = $this->modelFactory->create();
                $elogicForecast->setCityName($response['name'] ?? '');
                $elogicForecast->setCityCode($response['id'] ?? 0);
                $forecastResponse = $response['weather'] ?? [];
                $forecast = array_shift($forecastResponse);
                $elogicForecast->setData(ElogicForecastInterface::INFO, $forecast);
                $elogicForecast->setData(ElogicForecastInterface::MAIN, $response[ElogicForecastInterface::MAIN] ?? '');
                $elogicForecast->setData(ElogicForecastInterface::WIND, $response[ElogicForecastInterface::WIND] ?? '');
                $this->elogicForecastRepository->save($elogicForecast);
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }

        return $this;
    }
}
