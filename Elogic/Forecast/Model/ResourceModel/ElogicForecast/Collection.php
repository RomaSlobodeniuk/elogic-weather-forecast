<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model\ResourceModel\ElogicForecast;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Model\ElogicForecast;
use Elogic\Forecast\Model\ResourceModel\ElogicForecastResource;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DataObject;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 *
 * Elogic Forecast Collection model
 */
class Collection extends AbstractCollection
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        SerializerInterface $serializer,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->serializer = $serializer;
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ElogicForecast::class,
            ElogicForecastResource::class
        );
    }

    /**
     * @param DataObject $item
     * @return DataObject
     */
    protected function beforeAddLoadedItem(DataObject $item): DataObject
    {
        $additional  = [
            ElogicForecastInterface::INFO => $this->unSerialize($item->getData(ElogicForecastInterface::INFO)),
            ElogicForecastInterface::MAIN => $this->unSerialize($item->getData(ElogicForecastInterface::MAIN)),
            ElogicForecastInterface::WIND => $this->unSerialize($item->getData(ElogicForecastInterface::WIND))
        ];
        $item->setData('additional', $additional);
        return parent::beforeAddLoadedItem($item);
    }

    /**
     * @param string $data
     * @return array|bool|float|int|string|null
     */
    private function unSerialize(string $data)
    {
        return $this->serializer->unserialize($data);
    }
}
