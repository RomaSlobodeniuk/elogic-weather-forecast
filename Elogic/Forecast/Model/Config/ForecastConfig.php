<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ForecastConfig
 *
 * Forecast helper provides an additional functionality
 */
class ForecastConfig implements ArgumentInterface
{
    /**
     * XML PATH for the elogic forecast enabled config option
     */
    public const ELOGIC_GENERAL_ENABLED = 'elogic/general/enabled';

    /**
     * XML PATH for the elogic forecast API Url config option
     */
    public const ELOGIC_GENERAL_API_URL = 'elogic/general/api_url';

    /**
     * XML PATH for the elogic forecast API Key config option
     */
    public const ELOGIC_GENERAL_API_KEY = 'elogic/general/api_key';

    /**
     * XML PATH for the elogic forecast City ID config option
     */
    public const ELOGIC_GENERAL_CITY_ID = 'elogic/general/city_id';

    /**
     * XML PATH for the elogic forecast Units config option
     */
    public const ELOGIC_GENERAL_UNITS = 'elogic/general/units';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var int|null
     */
    private ?int $storeId = null;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @return int|null
     */
    private function getStoreId(): ?int
    {
        if ($this->storeId === null) {
            try {
                $store = $this->storeManager->getStore();
                $this->storeId = (int)$store->getId();
            } catch (NoSuchEntityException $exception) {
                $this->storeId = null;
            }
        }

        return $this->storeId;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getValue(string $path)
    {
        $storeId = $this->getStoreId();
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isSetFlag(string $path): bool
    {
        $storeId = $this->getStoreId();
        return $this->scopeConfig->isSetFlag(
            $path,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * @return bool
     */
    public function getIsEnabled(): bool
    {
        return $this->isSetFlag(self::ELOGIC_GENERAL_ENABLED);
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->getValue(self::ELOGIC_GENERAL_API_URL);
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getValue(self::ELOGIC_GENERAL_API_KEY);
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->getValue(self::ELOGIC_GENERAL_CITY_ID);
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->getValue(self::ELOGIC_GENERAL_UNITS);
    }
}
