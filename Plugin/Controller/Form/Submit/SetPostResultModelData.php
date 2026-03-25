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

namespace MageMe\WebFormsMailchimp\Plugin\Controller\Form\Submit;

use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Helper\Result\PostHelper;
use MageMe\WebFormsMailchimp\Helper\Mailchimp\AddUpdateMember;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class SetPostResultModelData
{
    /**
     * @var AddUpdateMember
     */
    private $addUpdateMember;

    /**
     * @param AddUpdateMember $addUpdateMember
     */
    public function __construct(
        AddUpdateMember $addUpdateMember
    ) {
        $this->addUpdateMember = $addUpdateMember;
    }

    /**
     * @param PostHelper $postHelper
     * @param $void
     * @param FormInterface $form
     * @param ResultInterface $result
     * @param array $postData
     * @param bool $isNewResult
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @noinspection PhpUnusedParameterInspection
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    public function afterSetPostResultModelData(
        PostHelper $postHelper,
        $void,
        FormInterface $form,
        ResultInterface &$result,
        array $postData,
        bool $isNewResult
    ) {
        $this->addUpdateMember->execute($form, $result);
    }
}

