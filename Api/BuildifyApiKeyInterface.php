<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Api;

/**
 * Interface BuildifyApiKeyInterface to saving and getting data of keys
 */
interface BuildifyApiKeyInterface
{
    /**
     * Get public key
     *
     * @return string|null
     */
    public function getPublicKey(): ?string;

    /**
     * Get private key
     *
     * @return string|null
     */
    public function getPrivateKey(): ?string;

    /**
     * Save data of keys
     *
     * @param string $publicKey
     * @param string $privateKey
     * @return void
     */
    public function save(string $publicKey, string $privateKey): void;
}
