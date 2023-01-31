<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Mi Cuenta Web plugin for Magento 2. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
namespace Lyranetwork\Micuentaweb\Controller\Adminhtml\Payment;

class Check extends \Magento\Backend\App\Action
{
    /**
     * @var \Lyranetwork\Micuentaweb\Controller\Processor\CheckProcessor
     */
    protected $checkProcessor;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $rawResultFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Lyranetwork\Micuentaweb\Controller\Processor\CheckProcessor $checkProcessor
     * @param \Magento\Framework\Controller\Result\RawFactory $rawResultFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Lyranetwork\Micuentaweb\Controller\Processor\CheckProcessor $checkProcessor,
        \Magento\Framework\Controller\Result\RawFactory $rawResultFactory
    ) {
        $this->checkProcessor = $checkProcessor;
        $this->rawResultFactory = $rawResultFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        if (! $this->getRequest()->isPost()) {
            return;
        }

        try {
            $params = $this->getRequest()->getParams();
            $data = $this->prepareResponse($params);

            $order = $data['order'];
            $response = $data['response'];

            $case = $this->checkProcessor->execute($order, $response);
            return $this->renderResponse($response->getOutputForGateway($case));
        } catch (\Lyranetwork\Micuentaweb\Model\ResponseException $e) {
            return $this->renderResponse($e->getMessage());
        }
    }

    protected function prepareResponse($params)
    {
        return $this->checkProcessor->prepareResponse($params);
    }

    protected function renderResponse($text)
    {
        $rawResult = $this->rawResultFactory->create();
        $rawResult->setContents($text);

        return $rawResult;
    }
}
