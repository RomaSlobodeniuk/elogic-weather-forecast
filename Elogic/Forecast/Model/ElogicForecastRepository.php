<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Api\Data\ElogicForecastSearchResultInterface;
use Elogic\Forecast\Api\Data\ElogicForecastSearchResultInterfaceFactory;
use Elogic\Forecast\Api\ElogicForecastRepositoryInterface;
use Elogic\Forecast\Model\ResourceModel\ElogicForecastResource;
use Elogic\Forecast\Model\ResourceModel\ElogicForecast\CollectionFactory as ElogicForecastCollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ElogicForecastRepository
 *
 * Elogic Forecast Repository implements management logic for the elogic forecast entities
 */
class ElogicForecastRepository implements ElogicForecastRepositoryInterface
{
    /**
     * @var ElogicForecastFactory
     */
    private ElogicForecastFactory $elogicForecastFactory;

    /**
     * @var ElogicForecastCollectionFactory
     */
    private ElogicForecastCollectionFactory $elogicForecastCollectionFactory;

    /**
     * @var ElogicForecastSearchResultInterfaceFactory
     */
    private ElogicForecastSearchResultInterfaceFactory $searchResultFactory;

    /**
     * @var ElogicForecastResource
     */
    private ElogicForecastResource $elogicForecastResource;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @param ElogicForecastFactory $elogicForecastFactory
     * @param ElogicForecastCollectionFactory $elogicForecastCollectionFactory
     * @param ElogicForecastResource $elogicForecastResource
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ElogicForecastSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        ElogicForecastFactory $elogicForecastFactory,
        ElogicForecastCollectionFactory $elogicForecastCollectionFactory,
        ElogicForecastResource $elogicForecastResource,
        CollectionProcessorInterface $collectionProcessor,
        ElogicForecastSearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->elogicForecastFactory = $elogicForecastFactory;
        $this->elogicForecastCollectionFactory = $elogicForecastCollectionFactory;
        $this->elogicForecastResource = $elogicForecastResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $entityId): ElogicForecastInterface
    {
        $model = $this->elogicForecastFactory->create();
        $this->elogicForecastResource->load($model, $entityId);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('No such entity with ID "%1"', $entityId));
        }

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function save(ElogicForecastInterface $elogicForecast): ElogicForecastInterface
    {
        $this->elogicForecastResource->save($elogicForecast);
        return $elogicForecast;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(ElogicForecastInterface $elogicForecast): void
    {
        try {
            $this->elogicForecastResource->delete($elogicForecast);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entity with ID: %1', $exception->getMessage())
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ElogicForecastSearchResultInterface
    {
        $collection = $this->elogicForecastCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
