<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class ElogicForecast
 *
 * Elogic Forecast entity model representation
 */
class ElogicForecast extends AbstractExtensibleModel implements ElogicForecastInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        SerializerInterface $serializer,
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\ElogicForecastResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): int
    {
        return (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $entityId
     * @return void
     */
    public function setEntityId($entityId): void
    {
        $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getCityName(): ?string
    {
        return $this->getData(self::CITY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setCityName(?string $cityName): void
    {
        $this->setData(self::CITY_NAME, $cityName);
    }

    /**
     * @inheritDoc
     */
    public function getCityCode(): int
    {
        return (int)$this->getData(self::CITY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCityCode(int $cityCode): void
    {
        $this->setData(self::CITY_CODE, $cityCode);
    }

    /**
     * @inheritDoc
     */
    public function getInfo(): string
    {
        return $this->getData(self::INFO);
    }

    /**
     * @inheritDoc
     */
    public function setInfo(string $info): void
    {
        $this->setData(self::INFO, $info);
    }

    /**
     * @inheritDoc
     */
    public function getMain(): ?string
    {
        return $this->getData(self::MAIN);
    }

    /**
     * @inheritDoc
     */
    public function setMain(?string $main): void
    {
        $this->setData(self::MAIN, $main);
    }

    /**
     * @inheritDoc
     */
    public function getWind(): ?string
    {
        return $this->getData(self::WIND);
    }

    /**
     * @inheritDoc
     */
    public function setWind(?string $wind): void
    {
        $this->setData(self::WIND, $wind);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return ElogicForecast
     */
    public function beforeSave(): ElogicForecast
    {
        $this->setInfo($this->serializer->serialize($this->getData(self::INFO)));
        $this->setMain($this->serializer->serialize($this->getData(self::MAIN)));
        $this->setWind($this->serializer->serialize($this->getData(self::WIND)));
        return parent::beforeSave();
    }

    /**
     * @return \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface
     */
    public function getExtensionAttributes(): \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface $extensionAttributes
     */
    public function setExtensionAttributes(
        \Elogic\Forecast\Api\Data\ElogicForecastExtensionInterface $extensionAttributes
    ): void {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
