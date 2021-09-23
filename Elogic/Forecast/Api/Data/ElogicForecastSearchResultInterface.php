<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ElogicForecastResultInterface
 *
 * Search results interface for the Elogic Forecast items found
 */
interface ElogicForecastSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ElogicForecastInterface[]
     */
    public function getItems();

    /**
     * @param ElogicForecastInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
