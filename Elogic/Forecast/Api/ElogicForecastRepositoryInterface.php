<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Api;

use Elogic\Forecast\Api\Data\ElogicForecastInterface;
use Elogic\Forecast\Api\Data\ElogicForecastSearchResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ElogicForecastRepositoryInterface
 *
 * Repository interface for managing Elogic Forecast entities
 */
interface ElogicForecastRepositoryInterface
{
    /**
     * Get Elogic Forecast entity by the provided id
     *
     * @param int $entityId
     * @return ElogicForecastInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): ElogicForecastInterface;

    /**
     * Save Elogic Forecast entity
     *
     * @param ElogicForecastInterface $elogicForecast
     * @return ElogicForecastInterface
     * @throws AlreadyExistsException
     */
    public function save(ElogicForecastInterface $elogicForecast): ElogicForecastInterface;

    /**
     * Delete Elogic Forecast entity
     *
     * @param ElogicForecastInterface $elogicForecast
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(ElogicForecastInterface $elogicForecast): void;

    /**
     * Get list of Elogic Forecast entities by provided search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ElogicForecastSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ElogicForecastSearchResultInterface;
}
