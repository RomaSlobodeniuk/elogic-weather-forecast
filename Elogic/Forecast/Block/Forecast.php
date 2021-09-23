<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Block;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Api\ElogicForecastRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Forecast
 *
 * Block provides with forecast data
 */
class Forecast extends Template
{
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * @var ElogicForecastRepositoryInterface
     */
    protected ElogicForecastRepositoryInterface $elogicForecastRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected SortOrderBuilder $sortOrderBuilder;

    /**
     * @var ElogicForecastInterface|null
     */
    private ?ElogicForecastInterface $elogicForecast = null;

    /**
     * @param SerializerInterface $serializer
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param ElogicForecastRepositoryInterface $elogicForecastRepository
     */
    public function __construct(
        SerializerInterface $serializer,
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        ElogicForecastRepositoryInterface $elogicForecastRepository
    ) {
        parent::__construct($context);
        $this->serializer = $serializer;
        $this->elogicForecastRepository = $elogicForecastRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return ElogicForecastInterface|null
     */
    public function getForecastData(): ?ElogicForecastInterface
    {
        if ($this->elogicForecast === null) {
            $sortOrder = $this->sortOrderBuilder
                ->setField(ElogicForecastInterface::CREATED_AT)
                ->setDirection(SortOrder::SORT_DESC)
                ->create();
            $searchCriteria = $this->searchCriteriaBuilder
                ->setSortOrders([$sortOrder])
                ->setPageSize(1)
                ->create();
            $searchResults = $this->elogicForecastRepository->getList($searchCriteria);
            if ($searchResults->getTotalCount()) {
                $elogicForecasts = $searchResults->getItems();
                $this->elogicForecast = array_shift($elogicForecasts);
            }
        }

        return $this->elogicForecast;
    }
}
