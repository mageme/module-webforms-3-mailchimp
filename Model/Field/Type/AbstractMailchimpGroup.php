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

namespace MageMe\WebFormsMailchimp\Model\Field\Type;

use MageMe\WebForms\Api\Ui\FieldUiInterface;
use MageMe\WebForms\Api\Utility\Field\FieldBlockInterface;
use MageMe\WebForms\Model\Field\AbstractField;
use MageMe\WebForms\Model\Field\Context;
use MageMe\WebFormsMailchimp\Helper\MailchimpHelper;
use Magento\Framework\Data\OptionSourceInterface;
use Mailchimp_Error;
use Mailchimp_HttpError;

abstract class AbstractMailchimpGroup extends AbstractField implements OptionSourceInterface
{
    /**
     * Attributes
     */
    const MAILCHIMP_CATEGORY = 'mailchimp_category';
    /**
     * @var array
     */
    protected $options;
    /**
     * @var MailchimpHelper
     */
    protected $mailchimpHelper;

    /**
     * @param MailchimpHelper $mailchimpHelper
     * @param Context $context
     * @param FieldUiInterface $fieldUi
     * @param FieldBlockInterface $fieldBlock
     */
    public function __construct(
        MailchimpHelper $mailchimpHelper,
        Context $context, FieldUiInterface $fieldUi, FieldBlockInterface $fieldBlock)
    {
        parent::__construct($context, $fieldUi, $fieldBlock);
        $this->mailchimpHelper = $mailchimpHelper;
    }

    #region type attributes
    /**
     * Get mailchimpCategory
     *
     * @return string
     */
    public function getMailchimpCategory(): string
    {
        return (string)$this->getData(self::MAILCHIMP_CATEGORY);
    }

    /**
     * Set mailchimpCategory
     *
     * @param string $mailchimpCategory
     * @return $this
     */
    public function setMailchimpCategory(string $mailchimpCategory): AbstractMailchimpGroup
    {
        return $this->setData(self::MAILCHIMP_CATEGORY, $mailchimpCategory);
    }
    #endregion

    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        if ($this->options) {
            return $this->options;
        }
        $this->options = [];
        $api = $this->mailchimpHelper->getMailchimpApi();
        $listId = $this->mailchimpHelper->getListId();
        $category = $this->getMailchimpCategory();

        try {
            foreach ($api->call("/lists/$listId/interest-categories/$category/interests",
                null)['interests'] as $interest) {
                $this->options[] = [
                    'label' => $interest['name'],
                    'value' => $interest['id'],
                ];
            }
        } catch (Mailchimp_HttpError | Mailchimp_Error $e) {
            $this->mailchimpHelper->getMailchimpData()->log($e->getFriendlyMessage());
        }
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function getValueForResultTemplate($value, ?int $resultId = null, array $options = [])
    {
        $values = is_array($value) ? $value : explode("\n", (string)$value);
        $arr = [];
        foreach ($values as $item) {
            $label = $this->getGroupLabel($item);
            if ($label) {
                $arr[] = $label;
            }
        }
        return implode("\n", $arr);
    }

    /**
     * @inheritDoc
     */
    public function getValueForResultHtml($value, array $options = [])
    {
        return parent::getValueForResultHtml($this->getValueForResultTemplate($value));
    }

    /**
     * @inheritDoc
     */
    public function getResultCollectionFilterCondition($value, string $prefix = '%'): string
    {
        $id          = $this->getId();
        $searchValue = $this->getResultCollectionFilterConditionSearchValue($value);
        return "results_values_$id.value like '" . $searchValue . "'";
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getGroupLabel(string $value): string
    {
        foreach ($this->toOptionArray() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return '';
    }
}
