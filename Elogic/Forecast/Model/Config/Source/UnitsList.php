<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class UnitsList
 *
 * The units list
 */
class UnitsList implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'standard', 'label' => __('Standard')],
            ['value' => 'metric', 'label' => __('Metric')],
            ['value' => 'imperial', 'label' => __('Imperial')]
        ];
    }
}
