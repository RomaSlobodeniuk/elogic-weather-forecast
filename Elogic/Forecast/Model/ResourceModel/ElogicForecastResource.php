<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ElogicForecastResource
 *
 * Elogic Forecast resource model
 */
class ElogicForecastResource extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elogic_forecast', 'entity_id');
    }
}
