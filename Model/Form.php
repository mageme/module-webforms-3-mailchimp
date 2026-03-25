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

namespace MageMe\WebFormsMailchimp\Model;

use MageMe\WebFormsMailchimp\Api\Data\FormInterface;

class Form extends \MageMe\WebForms\Model\Form implements FormInterface
{
    #region DB getters and setters
    /**
     * @inheritDoc
     */
    public function getIsMailchimpEnabled(): bool
    {
        return (bool)$this->getData(self::IS_MAILCHIMP_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setIsMailchimpEnabled(bool $isMailchimpEnabled): FormInterface
    {
        return $this->setData(self::IS_MAILCHIMP_ENABLED, $isMailchimpEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getMailchimpEmailFieldId(): ?int
    {
        return $this->getData(self::MAILCHIMP_EMAIL_FIELD_ID);
    }

    /**
     * @inheritDoc
     */
    public function setMailchimpEmailFieldId(?int $mailchimpEmailFieldId): FormInterface
    {
        return $this->setData(self::MAILCHIMP_EMAIL_FIELD_ID, $mailchimpEmailFieldId);
    }

    /**
     * @inheritDoc
     */
    public function getMailchimpMapFieldsSerialized(): ?string
    {
        return $this->getData(self::MAILCHIMP_MAP_FIELDS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setMailchimpMapFieldsSerialized(string $mailchimpMapFieldsSerialized): FormInterface
    {
        return $this->setData(self::MAILCHIMP_MAP_FIELDS_SERIALIZED, $mailchimpMapFieldsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getMailchimpTagsSerialized(): ?string
    {
        return $this->getData(self::MAILCHIMP_TAGS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setMailchimpTagsSerialized(string $mailchimpTagsSerialized): FormInterface
    {
        return $this->setData(self::MAILCHIMP_TAGS_SERIALIZED, $mailchimpTagsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getMailchimpMapFields(): array
    {
        $data = $this->getData(self::MAILCHIMP_MAP_FIELDS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setMailchimpMapFields(array $mailchimpMapFields): FormInterface
    {
        return $this->setData(self::MAILCHIMP_MAP_FIELDS, $mailchimpMapFields);
    }

    /**
     * @inheritDoc
     */
    public function getMailchimpTags(): array
    {
        $data = $this->getData(self::MAILCHIMP_TAGS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setMailchimpTags(array $mailchimpTags): FormInterface
    {
        return $this->setData(self::MAILCHIMP_TAGS, $mailchimpTags);
    }

#endregion
}
