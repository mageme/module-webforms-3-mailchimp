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

namespace MageMe\WebFormsMailchimp\Ui\Component\Form\Form\Modifier;

use Ebizmarts\MailChimp\Helper\Data;
use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface as FormInterfaceAlias;
use MageMe\WebForms\Api\FormRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\Email;
use MageMe\WebFormsMailchimp\Api\Data\FormInterface;
use MageMe\WebFormsMailchimp\Config\Constant\MailchimpType;
use MageMe\WebFormsMailchimp\Config\Constant\MailchimpType\Address;
use MageMe\WebFormsMailchimp\Helper\MailchimpHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Mailchimp_Error;
use Mailchimp_HttpError;

class MailChimpIntegrationSettings implements ModifierInterface
{
    const MAILCHIMP_FIELD_ID = 'mailchimp_field_id';
    const MAILCHIMP_CATEGORY_ID = 'mailchimp_category_id';

    /**
     * @var FormRepositoryInterface
     */
    private $formRepository;
    /**
     * @var MailchimpHelper
     */
    private $mailchimpHelper;

    /**
     * @param FormRepositoryInterface $formRepository
     * @param MailchimpHelper $mailchimpHelper
     */
    public function __construct(
        FormRepositoryInterface $formRepository,
        MailchimpHelper $mailchimpHelper
    ) {
        $this->mailchimpHelper = $mailchimpHelper;
        $this->formRepository = $formRepository;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta): array
    {
        $meta['mailchimp_integration_settings'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Fieldset::NAME,
                        'label' => __('Mailchimp Integration Settings'),
                        'sortOrder' => 140,
                        'collapsible' => true,
                        'opened' => false,
                    ]
                ]
            ],
            'children' => [
                FormInterface::IS_MAILCHIMP_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 10,
                                'label' => __('Enable Mailchimp Integration'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::MAILCHIMP_EMAIL_FIELD_ID => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 20,
                                'label' => __('Customer Email'),
                                'options' => $this->getFields(Email::class),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::MAILCHIMP_MAP_FIELDS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => DynamicRows::NAME,
                                'visible' => 1,
                                'sortOrder' => 30,
                                'label' => __('Fields Mapping'),
                            ]
                        ]
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Container::NAME,
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                    ]
                                ]
                            ],
                            'children' => [
                                self::MAILCHIMP_FIELD_ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 10,
                                                'label' => __('Mailchimp'),
                                                'options' => $this->getMailchimpFields(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                FieldInterface::ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 20,
                                                'label' => __('Field'),
                                                'options' => $this->getFields(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                ActionDelete::NAME => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => ActionDelete::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'label' => '',
                                                'sortOrder' => 30,
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                FormInterface::MAILCHIMP_TAGS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\MultiSelect::NAME,
                                'visible' => 1,
                                'sortOrder' => 50,
                                'label' => __('Tags'),
                                'options' => $this->getMailchimpTags(),
                            ]
                        ]
                    ]
                ],
            ]
        ];
        return $meta;
    }

    /**
     * @return array
     */
    protected function getMailchimpFields(): array
    {
        $ret = [];
        $api = $this->mailchimpHelper->getMailchimpApi();
        try {
            $merge = $api->lists->mergeFields->getAll(
                $this->mailchimpHelper->getListId(),
                null,
                null,
                Data::MAX_MERGEFIELDS
            );
            if (is_array($merge) && key_exists('merge_fields', $merge)) {
                foreach ($merge['merge_fields'] as $item) {
                    switch ($item['type']) {
                        case MailchimpType::ADDRESS:
                        {
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('Street Address(required)') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::ADDRESS1
                            ];
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('Address Line 2') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::ADDRESS2
                            ];
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('City(required)') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::CITY
                            ];
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('State/Prov/Region(required)') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::STATE
                            ];
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('Postal/Zip(required)') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::ZIP
                            ];
                            $ret[] = [
                                'label' => $item['tag'] . ' ' . __('Country') . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type'] . ' ' . Address::COUNTRY
                            ];
                            break;
                        }
                        default:
                        {
                            $ret[] = [
                                'label' => $item['tag'] . ' (' . $item['name'] . ' : ' . $item['type'] . ')',
                                'value' => $item['tag'] . ' ' . $item['type']
                            ];
                            break;
                        }
                    }
                }
            }
        } catch (Mailchimp_Error $e) {
            $this->mailchimpHelper->getMailchimpData()->log($e->getFriendlyMessage());
        }
        return $ret;
    }

    /**
     * @param mixed $type
     * @return array
     */
    protected function getFields($type = false): array
    {
        $formId = (int)$this->mailchimpHelper->getRequest()->getParam(FormInterfaceAlias::ID);
        if (!$formId) {
            return [];
        }
        try {
            return $this->formRepository->getById($formId)->getFieldsAsOptions($type);
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    protected function getMailchimpTags(): array
    {
        $options = [];
        $api = $this->mailchimpHelper->getMailchimpApi();
        $listId = $this->mailchimpHelper->getListId();

        try {
            foreach ($api->call("/lists/$listId/tag-search", null)['tags'] as $tag) {
                $options[] = [
                    'label' => $tag['name'],
                    'value' => $tag['name']
                ];
            }
        } catch (Mailchimp_HttpError | Mailchimp_Error $e) {
            $this->mailchimpHelper->getMailchimpData()->log($e->getFriendlyMessage());
        }
        return $options;
    }
}
