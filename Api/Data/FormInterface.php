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

namespace MageMe\WebFormsMailchimp\Api\Data;

interface FormInterface extends \MageMe\WebForms\Api\Data\FormInterface
{
    /** Mailchimp settings */
    const IS_MAILCHIMP_ENABLED = 'is_mailchimp_enabled';
    const MAILCHIMP_EMAIL_FIELD_ID = 'mailchimp_email_field_id';
    const MAILCHIMP_MAP_FIELDS_SERIALIZED = 'mailchimp_map_fields_serialized';
    const MAILCHIMP_TAGS_SERIALIZED = 'mailchimp_tags_serialized';

    /**
     * Additional constants for keys of data array.
     */
    const MAILCHIMP_MAP_FIELDS = 'mailchimp_map_fields';
    const MAILCHIMP_TAGS = 'mailchimp_tags';

    #region Mailchimp
    /**
     * Get isMailchimpEnabled
     *
     * @return bool
     */
    public function getIsMailchimpEnabled(): bool;
    /**
     * Set isMailchimpEnabled
     *
     * @param bool $isMailchimpEnabled
     * @return $this
     */
    public function setIsMailchimpEnabled(bool $isMailchimpEnabled): FormInterface;

    /**
     * Get mailchimpEmailFieldId
     *
     * @return int|null
     */
    public function getMailchimpEmailFieldId(): ?int;

    /**
     * Set mailchimpEmailFieldId
     *
     * @param int|null $mailchimpEmailFieldId
     * @return $this
     */
    public function setMailchimpEmailFieldId(?int $mailchimpEmailFieldId): FormInterface;

    /**
     * Get mailchimpMapFieldsSerialized
     *
     * @return string|null
     */
    public function getMailchimpMapFieldsSerialized(): ?string;

    /**
     * Set mailchimpMapFieldsSerialized
     *
     * @param string $mailchimpMapFieldsSerialized
     * @return $this
     */
    public function setMailchimpMapFieldsSerialized(string $mailchimpMapFieldsSerialized): FormInterface;

    /**
     * Get mailchimpTagsSerialized
     *
     * @return string|null
     */
    public function getMailchimpTagsSerialized(): ?string;

    /**
     * Set mailchimpTagsSerialized
     *
     * @param string $mailchimpTagsSerialized
     * @return $this
     */
    public function setMailchimpTagsSerialized(string $mailchimpTagsSerialized): FormInterface;

    /**
     * Get mailchimpMapFields
     *
     * @return array
     */
    public function getMailchimpMapFields(): array;

    /**
     * Set mailchimpMapFields
     *
     * @param array $mailchimpMapFields
     * @return $this
     */
    public function setMailchimpMapFields(array $mailchimpMapFields): FormInterface;

    /**
     * Get mailchimpTags
     *
     * @return array
     */
    public function getMailchimpTags(): array;

    /**
     * Set mailchimpTags
     *
     * @param array $mailchimpTags
     * @return $this
     */
    public function setMailchimpTags(array $mailchimpTags): FormInterface;
    #endregion
}
