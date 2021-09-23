<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Ui\DataProvider;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Api\ElogicForecastRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\SearchResultFactory;

/**
 * Class ElogicForecastDataProvider
 *
 * DataProvider component
 */
class ElogicForecastDataProvider extends DataProvider
{
    /**
     * @var ElogicForecastRepositoryInterface
     */
    private ElogicForecastRepositoryInterface $elogicForecastRepository;

    /**
     * @var SearchResultFactory
     */
    private SearchResultFactory $searchResultFactory;

    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param ElogicForecastRepositoryInterface $elogicForecastRepository
     * @param SearchResultFactory $searchResultFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        ElogicForecastRepositoryInterface $elogicForecastRepository,
        SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->elogicForecastRepository = $elogicForecastRepository;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $searchResults = $this->elogicForecastRepository->getList($searchCriteria);
        return $this->searchResultFactory->create(
            $searchResults->getItems(),
            $searchResults->getTotalCount(),
            $searchCriteria,
            ElogicForecastInterface::ENTITY_ID
        );
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        if (empty($this->loadedData)) {
            $this->loadedData = parent::getData();
            $itemsById = [];
            foreach ($this->loadedData['items'] as $item) {
                $itemsById[(int)$item[ElogicForecastInterface::ENTITY_ID]] = $item;
            }

            if ($id = $this->request->getParam(ElogicForecastInterface::ENTITY_ID)) {
                $this->loadedData['entity'] = $itemsById[(int)$id];
            }
        }

        return $this->loadedData;
    }
}
