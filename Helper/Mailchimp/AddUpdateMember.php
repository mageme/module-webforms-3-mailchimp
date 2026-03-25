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

namespace MageMe\WebFormsMailchimp\Helper\Mailchimp;

use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\FieldRepositoryInterface;
use MageMe\WebFormsMailchimp\Config\Constant\MailchimpType;
use MageMe\WebFormsMailchimp\Config\Constant\MailchimpType\Address;
use MageMe\WebFormsMailchimp\Helper\MailchimpHelper;
use MageMe\WebFormsMailchimp\Model\Field\Type\AbstractMailchimpGroup;
use MageMe\WebFormsMailchimp\Ui\Component\Form\Form\Modifier\MailChimpIntegrationSettings;
use Magento\Framework\Exception\NoSuchEntityException;
use Mailchimp;
use Mailchimp_Error;

class AddUpdateMember
{
    /**
     * @var MailchimpHelper
     */
    private $mailchimpHelper;
    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepository;

    /**
     * @param FieldRepositoryInterface $fieldRepository
     * @param MailchimpHelper $mailchimpHelper
     */
    public function __construct(
        FieldRepositoryInterface $fieldRepository,
        MailchimpHelper $mailchimpHelper
    ) {
        $this->mailchimpHelper = $mailchimpHelper;
        $this->fieldRepository = $fieldRepository;
    }

    /**
     * @param FormInterface $form
     * @param ResultInterface $result
     * @return mixed|null
     * @throws NoSuchEntityException
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function execute(FormInterface $form, ResultInterface $result) {
        $mailchimpData = $this->mailchimpHelper->getMailchimpData();
        if (!$mailchimpData->isMailChimpEnabled($result->getStoreId()) || !$form->getIsMailchimpEnabled()) {
            return null;
        }
        $listId = $this->mailchimpHelper->getListId();
        $email = $this->getEmail($form, $result);
        if (!$listId || empty($email)) {
            return null;
        }

        $api = $this->mailchimpHelper->getMailchimpApi();
        $status = $mailchimpData->isDoubleOptInEnabled($result->getStoreId()) ? 'pending' : 'subscribed';
        $mergeVars = $this->mapFields($form, $result);
        $groups = $this->getGroups($form, $result);

        $params = [
            'list_id' => $listId,
            'email_address' => $email,
            'email_type' => 'html',
            'status' => $status
        ];
        if (!empty($form->getMailchimpTags())) {
            $params['tags'] = $form->getMailchimpTags();
        }
        if (!empty($mergeVars)) {
            $params['merge_fields'] = $mergeVars;
        }
        if (!empty($groups)) {
            $params['interests'] = $groups;
        }
        $emailHash = md5(strtolower($email));
        try {
            return $api->call('lists/' . $listId . '/members/' . $emailHash, $params, Mailchimp::PUT);
        } catch (Mailchimp_Error $e) {
            $mailchimpData->log($e->getFriendlyMessage());
            return null;
        }
    }

    /**
     * @param FormInterface $form
     * @param ResultInterface $result
     * @return array
     * @throws NoSuchEntityException
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    protected function mapFields(FormInterface $form, ResultInterface $result): array
    {
        $values = $result->getFieldArray();
        $customer = $result->getCustomer();
        $mergeVars = $customer ? $this->mailchimpHelper->getMailchimpData()->getMergeVars($customer,
            $result->getStoreId()) : [];
        $mapFields = $form->getMailchimpMapFields();
        if (empty($mapFields)) {
            return $mergeVars;
        }
        foreach ($mapFields as $mapField) {
            if (empty($values[$mapField[FieldInterface::ID]])) {
                continue;
            }
            $value = $this->fieldRepository->getById((int)$mapField[FieldInterface::ID])
                ->getValueForResultTemplate($values[$mapField[FieldInterface::ID]], $result->getId());
            $arr = explode(' ', (string)$mapField[MailChimpIntegrationSettings::MAILCHIMP_FIELD_ID]);
            switch ($arr[1]) {
                case MailchimpType::ADDRESS:
                {
                    if (!isset($mergeVars[$arr[0]])) {
                        $mergeVars[$arr[0]] = [
                            Address::ADDRESS1 => '',
                            Address::ADDRESS2 => '',
                            Address::CITY => '',
                            Address::STATE => '',
                            Address::ZIP => '',
                            Address::COUNTRY => '',
                        ];
                    }
                    $mergeVars[$arr[0]][$arr[2]] = $value;
                    break;
                }
                default:
                {
                    $mergeVars[$arr[0]] = $value;
                    break;
                }
            }
        }
        return $mergeVars;
    }

    /**
     * @param FormInterface $form
     * @param ResultInterface $result
     * @return array
     */
    protected function getGroups(FormInterface $form, ResultInterface $result): array
    {
        $groups = [];
        $values = $result->getFieldArray();
        $groupFields = $form->getFieldsAsOptions(AbstractMailchimpGroup::class, ['with_fieldset' => false]);
        foreach ($groupFields as $groupField) {
            if (empty($groupField['value']) || empty($values[$groupField['value']])) {
                continue;
            }
            $value = $values[$groupField['value']];
            $arr = is_array($value) ? $value : explode("\n", (string)$value);
            foreach ($arr as $item) {
                $groups[$item] = true;
            }
        }
        return $groups;
    }

    /**
     * @param FormInterface $form
     * @param ResultInterface $result
     * @return string
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    protected function getEmail(FormInterface $form, ResultInterface $result): string
    {
        $values = $result->getFieldArray();
        $emailId = $form->getMailchimpEmailFieldId();
        $email = $values[$emailId] ?? '';
        if ($email) {
            return $email;
        }
        $emailList = $result->getCustomerEmail();
        return $emailList[0] ?? '';
    }
}
