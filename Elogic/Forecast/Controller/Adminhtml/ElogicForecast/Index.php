<?php

/**
 * Copyright © Elogic, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace Elogic\Forecast\Controller\Adminhtml\ElogicForecast;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 *
 * ElogicForecast backend index (list) controller
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    public const ADMIN_RESOURCE = 'Elogic_Forecast::management_forecast';

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Elogic_Forecast::management_forecast');
        $resultPage->addBreadcrumb(__('Elogic Forecast'), __('ElogicForecast'));
        $resultPage->addBreadcrumb(__('Manage Elogic Forecasts'), __('Manage Elogic Forecasts'));
        $resultPage->getConfig()->getTitle()->prepend(__('Elogic Forecast List'));

        return $resultPage;
    }
}
