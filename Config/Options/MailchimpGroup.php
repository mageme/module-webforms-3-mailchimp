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

namespace MageMe\WebFormsMailchimp\Config\Options;

use Ebizmarts\MailChimp\Helper\Data;
use MageMe\WebFormsMailchimp\Helper\MailchimpHelper;
use Magento\Framework\Data\OptionSourceInterface;
use Mailchimp_Error;
use Mailchimp_HttpError;

class MailchimpGroup implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var MailchimpHelper
     */
    private $mailchimpHelper;

    /**
     * @param MailchimpHelper $mailchimpHelper
     */
    public function __construct(MailchimpHelper $mailchimpHelper)
    {
        $this->mailchimpHelper = $mailchimpHelper;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        if ($this->options) {
            return $this->options;
        }
        try {
            $list = $this->mailchimpHelper->getMailchimpApi()->lists->interestCategory->getAll(
                $this->mailchimpHelper->getListId(),
                null,
                null,
                Data::MAXSTORES
            );
        } catch (Mailchimp_HttpError | Mailchimp_Error $e) {
            $this->mailchimpHelper->getMailchimpData()->log($e->getFriendlyMessage());
            return [];
        }
        if (is_array($list) && is_array($list['categories']) && count($list['categories'])) {
            $this->options = [];
            foreach ($list['categories'] as $interest) {
                $this->options[] = ['value' => $interest['id'], 'label' => $interest['title']];
            }
        } else {
            $this->options[] = ['value' => [], 'label' => __('---No Data---')];
        }
        return $this->options;
    }
}
