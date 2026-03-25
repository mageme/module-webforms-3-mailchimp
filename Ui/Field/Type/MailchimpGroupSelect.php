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

namespace MageMe\WebFormsMailchimp\Ui\Field\Type;

use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\Ui\FieldResultFormInterface;
use MageMe\WebForms\Api\Ui\FieldResultListingColumnInterface;
use MageMe\WebForms\Ui\Component\Common\Listing\Constants\BodyTmpl;
use MageMe\WebForms\Ui\Component\Common\Listing\Constants\Filter;
use MageMe\WebFormsMailchimp\Ui\Component\Result\Listing\Column\Field\MailchimpGroup as MailchimpGroupColumn;
use MageMe\WebForms\Ui\Field\AbstractField;
use MageMe\WebFormsMailchimp\Config\Options\MailchimpGroup;
use MageMe\WebFormsMailchimp\Model\Field\Type;
use Magento\Ui\Component\Form;

class MailchimpGroupSelect extends AbstractField implements FieldResultListingColumnInterface, FieldResultFormInterface
{
    const MAILCHIMP_CATEGORY = Type\AbstractMailchimpGroup::MAILCHIMP_CATEGORY;
    const IS_MULTISELECT = Type\MailchimpGroupSelect::IS_MULTISELECT;
    /**
     * @var MailchimpGroup
     */
    protected $mailchimpGroup;

    /**
     * @param MailchimpGroup $mailchimpGroup
     */
    public function __construct(MailchimpGroup $mailchimpGroup)
    {
        $this->mailchimpGroup = $mailchimpGroup;
    }

    /**
     * @inheritDoc
     */
    public function getUiMeta(string $prefix = ''): array
    {
        return [
            'information' => [
                'children' => [
                    $prefix . '_' . static::MAILCHIMP_CATEGORY => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'source' => 'field',
                                    'componentType' => Form\Field::NAME,
                                    'formElement' => Form\Element\Select::NAME,
                                    'dataType' => Form\Element\DataType\Text::NAME,
                                    'dataScope' => static::MAILCHIMP_CATEGORY,
                                    'visible' => 0,
                                    'sortOrder' => 65,
                                    'label' => __('Mailchimp Group'),
                                    'options' => $this->mailchimpGroup->toOptionArray(),
                                ]
                            ]
                        ]
                    ],
                    $prefix . '_' . static::IS_MULTISELECT => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'source' => 'field',
                                    'componentType' => Form\Field::NAME,
                                    'formElement' => Form\Element\Checkbox::NAME,
                                    'dataType' => Form\Element\DataType\Boolean::NAME,
                                    'dataScope' => static::IS_MULTISELECT,
                                    'visible' => 0,
                                    'sortOrder' => 66,
                                    'label' => __('Multiple Selection'),
                                    'additionalInfo' => __('Select multiple values'),
                                    'default' => '0',
                                    'prefer' => 'toggle',
                                    'valueMap' => ['false' => '0', 'true' => '1'],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getResultListingColumnConfig(int $sortOrder): array
    {
        $config             = $this->getDefaultUIResultColumnConfig($sortOrder);
        $config['filter']   = Filter::SELECT;
        $config['options']  = $this->getField()->toOptionArray();
        $config['class']    = MailchimpGroupColumn::class;
        $config['bodyTmpl'] = BodyTmpl::HTML;
        return $config;
    }

    /**
     * @inheritDoc
     */
    public function getResultAdminFormConfig(?ResultInterface $result = null): array
    {
        $config           = $this->getDefaultResultAdminFormConfig();
        $config['type']   = $this->getField()->getIsMultiselect() ? 'multiselect' : 'select';
        $config['values'] = $this->getField()->toOptionArray();
        return $config;
    }
}
