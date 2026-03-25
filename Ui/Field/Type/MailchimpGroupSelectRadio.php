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
use MageMe\WebFormsMailchimp\Model\Field\Type;
use Magento\Ui\Component\Form;

class MailchimpGroupSelectRadio extends MailchimpGroupSelect
{
    const IS_INTERNAL_ELEMENTS_INLINE = Type\MailchimpGroupSelectRadio::IS_INTERNAL_ELEMENTS_INLINE;

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
                    $prefix . '_' . static::IS_INTERNAL_ELEMENTS_INLINE => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'source' => 'field',
                                    'componentType' => Form\Field::NAME,
                                    'formElement' => Form\Element\Checkbox::NAME,
                                    'dataType' => Form\Element\DataType\Boolean::NAME,
                                    'dataScope' => static::IS_INTERNAL_ELEMENTS_INLINE,
                                    'visible' => 0,
                                    'sortOrder' => 66,
                                    'label' => __('Inline Elements'),
                                    'additionalInfo' => __('Display elements of the field inline instead of the column'),
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
    public function getResultAdminFormConfig(?ResultInterface $result = null): array
    {
        $config             = $this->getDefaultResultAdminFormConfig();
        $config['type']     = 'select';
        $config['required'] = false;
        $config['values']   = $this->getField()->toOptionArray();
        return $config;
    }

}
