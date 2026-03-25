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

namespace MageMe\WebFormsMailchimp\Block\Form\Element\Field\Type;

use MageMe\WebForms\Block\Form\Element\Field\AbstractField;

class MailchimpGroupSelectCheckbox extends AbstractField
{
    /**
     * Block's template
     * @var string
     */
    protected $_template = self::TEMPLATE_PATH . 'mailchimp_group_select_checkbox.phtml';

    /**
     * @inheritDoc
     */
    public function getFieldName(): string
    {
        return parent::getFieldName() . '[]';
    }

    /**
     * @return array
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function getFieldOptions(): array
    {
        return $this->field->toOptionArray();
    }
}
