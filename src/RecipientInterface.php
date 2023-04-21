<?php

namespace PE\Component\Messenger;

/**
 * For each type recipient can have multiple identities (contact information) so how to use it???
 *
 * Identities by channel type and optionally transport:
 * - Mail: address@emample.com
 * - SMS: +<country_code><area_code><local_number>
 * - Telegram: @<username> or https://t.me/<username>
 * - WhatsApp: https://wa.me/<international_phone_number>
 * - Viber: unique user id, better to use partner api (infobip as example)
 * - Facebook: unique user id, maybe better as for viber
 * - Push: depends on subscriptions inside system
 */
interface RecipientInterface
{
    /**
     * Get internal ID, can be any string but prefer UUID
     *
     * @return string
     */
    public function getInternalID(): string;

    /**
     * Get chat channel identity, depends on transport name
     *
     * @param string $transportName
     * @return string
     */
    public function getChatIdentity(string $transportName): string;

    /**
     * Get mail channel identity
     *
     * @return string
     */
    public function getEmailIdentity(): string;

    /**
     * Get SMS channel identity
     *
     * @return string
     */
    public function getPhoneIdentity(): string;

    /**
     * Get push channel identity, depends on transport name
     *
     * @param string $transportName
     * @return string
     */
    public function getPushIdentity(string $transportName): string;

    /**
     * Get vars for template, as example firstName, lastName, ...
     *
     * @return array
     */
    public function getVars(): array;
}