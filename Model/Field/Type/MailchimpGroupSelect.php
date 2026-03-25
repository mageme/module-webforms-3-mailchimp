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

class MailchimpGroupSelect extends AbstractMailchimpGroup
{
    /**
     * Attributes
     */
    const IS_MULTISELECT = 'is_multiselect';

    #region type attributes
    /**
     * Get multiselect flag
     *
     * @return bool
     */
    public function getIsMultiselect(): bool
    {
        return (bool)$this->getData(self::IS_MULTISELECT);
    }

    /**
     * Set multiselect flag
     *
     * @param bool $isMultiselect
     * @return $this
     */
    public function setIsMultiselect(bool $isMultiselect): MailchimpGroupSelect
    {
        return $this->setData(self::IS_MULTISELECT, $isMultiselect);
    }
    #endregion

    /**
     * @inheritDoc
     * @noinspection DuplicatedCode
     */
    public function getValidation(): array
    {
        $validation = parent::getValidation();
        if ($this->getIsRequired()) {
            unset($validation['rules']['required-entry']);
            $validation['rules']['validate-select'] = "'validate-select':true";
            if ($this->getValidationRequiredMessage()) {
                unset($validation['descriptions']['data-msg-required-entry']);
                $validation['descriptions']['data-msg-validate-select'] = $this->getValidationRequiredMessage();
            }
        }
        return $validation;
    }
}
