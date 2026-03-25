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

class MailchimpGroupSelect extends AbstractField
{
    /**
     * Block's template
     * @var string
     */
    protected $_template = self::TEMPLATE_PATH . 'mailchimp_group_select.phtml';

    /**
     * @inheritDoc
     */
    public function getFieldName(): string
    {
        $name = parent::getFieldName();
        if ($this->getIsMultiselect()) {
            $name .= '[]';
        }
        return $name;
    }

    /**
     * @inheritDoc
     */
    public function getFieldClass(): string
    {
        $class = parent::getFieldClass();
        if ($this->getIsMultiselect()) {
            $class .= ' multiselect';
        }
        return $class;
    }

    /**
     * @return array
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function getFieldOptions(): array
    {
        return $this->field->toOptionArray();
    }

    /**
     * @return bool
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function getIsMultiselect(): bool
    {
        return $this->field->getIsMultiselect();
    }
}
