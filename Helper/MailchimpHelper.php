<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to a newer
 * version in the future.
 *
 * Copyright (c) MageMe (https://mageme.com)
 **/

namespace MageMe\WebFormsMailchimp\Helper;

use Ebizmarts\MailChimp\Helper\Data;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Mailchimp;

class MailchimpHelper
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var Data
     */
    private $mailchimpData;

    /**
     * @param Data $mailchimpData
     * @param RequestInterface $request
     */
    public function __construct(Data $mailchimpData,
        RequestInterface $request)
    {
        $this->request = $request;
        $this->mailchimpData = $mailchimpData;
    }

    /**
     * @return Mailchimp
     */
    public function getMailchimpApi(): Mailchimp
    {
        list($storeId, $scope) = $this->getStoreIdAndScope();
        return $this->mailchimpData->getApi($storeId, $scope);
    }

    /**
     * @return string|mixed
     */
    public function getListId(): ?string
    {
        list($storeId, $scope) = $this->getStoreIdAndScope();
        try {
            return $this->mailchimpData->getConfigValue(
                Data::XML_PATH_LIST,
                $storeId,
                $scope
            );
        } catch (LocalizedException $e) {
            return '';
        }
    }

    /**
     * @return Data
     */
    public function getMailchimpData(): Data
    {
        return $this->mailchimpData;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return array
     */
    private function getStoreIdAndScope(): array
    {
        $storeId = (int)$this->request->getParam('store', 0);
        if ($this->request->getParam('website', 0)) {
            $scope = 'website';
            $storeId = $this->request->getParam('website', 0);
        } elseif ($this->request->getParam('store', 0)) {
            $scope = 'stores';
            $storeId = $this->request->getParam('store', 0);
        } else {
            $scope = 'default';
        }
        return [$storeId, $scope];
    }

}
