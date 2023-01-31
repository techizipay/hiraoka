<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Mi Cuenta Web plugin for Magento 2. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
namespace Lyranetwork\Micuentaweb\Block\Payment;

class Redirect extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context, $data);
    }

    /**
     * Get Form data by using ops payment api.
     *
     * @return array
     */
    public function getFormFields()
    {
        return $this->coreRegistry->registry(\Lyranetwork\Micuentaweb\Block\Constants::PARAMS_REGISTRY_KEY);
    }

    /**
     * Getting gateway url.
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->coreRegistry->registry(\Lyranetwork\Micuentaweb\Block\Constants::URL_REGISTRY_KEY);
    }
}
