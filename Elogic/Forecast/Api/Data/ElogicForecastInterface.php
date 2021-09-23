<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ElogicForecastInterface
 *
 * Forecast interface represents the entity
 */
interface ElogicForecastInterface extends ExtensibleDataInterface
{
    /**
     * String constant for an `entity_id` column
     */
    public const ENTITY_ID = "entity_id";

    /**
     * String constant for an `info` column
     */
    public const INFO = "info";

    /**
     * String constant for a `main` column
     */
    public const MAIN = "main";

    /**
     * String constant for a `wind` column
     */
    public const WIND = "wind";

    /**
     * String constant for a `city_name` column
     */
    public const CITY_NAME = "city_name";

    /**
     * String constant for an `city_code` column
     */
    public const CITY_CODE = "city_code";

    /**
     * String constant for a `created_at` column
     */
    public const CREATED_AT = "created_at";

    /**
     * Getter for an EntityId property
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Setter for an EntityId property
     *
     * @param int $entityId
     *
     * @return void
     */
    public function setEntityId(int $entityId): void;

    /**
     * Getter for a City Name property
     *
     * @return string|null
     */
    public function getCityName(): ?string;

    /**
     * Setter for a City Name property
     *
     * @param string|null $cityName
     * @return void
     */
    public function setCityName(?string $cityName): void;

    /**
     * Getter for a City Code property
     *
     * @return int
     */
    public function getCityCode(): int;

    /**
     * Setter for a City property
     *
     * @param int $cityCode
     * @return void
     */
    public function setCityCode(int $cityCode): void;

    /**
     * Getter for an Info property
     *
     * @return string|null
     */
    public function getInfo(): ?string;

    /**
     * Setter for an Info property
     *
     * @param string|null $info
     *
     * @return void
     */
    public function setInfo(string $info): void;

    /**
     * Getter for a Main property
     *
     * @return string|null
     */
    public function getMain(): ?string;

    /**
     * Setter for a Main property
     *
     * @param string|null $main
     *
     * @return void
     */
    public function setMain(?string $main): void;

    /**
     * Getter for a Wind property
     *
     * @return string|null
     */
    public function getWind(): ?string;

    /**
     * Setter for a Wind property
     *
     * @param string|null $wind
     *
     * @return void
     */
    public function setWind(?string $wind): void;

    /**
     * Getter for a CreatedAt property
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for an Elogic Forecast extension attributes
     *
     * @return \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface
     */
    public function getExtensionAttributes(): \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface;

    /**
     * Getter for an Elogic Forecast extension attributes
     *
     * @param \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(
        \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface $extensionAttributes
    ): void;
}
