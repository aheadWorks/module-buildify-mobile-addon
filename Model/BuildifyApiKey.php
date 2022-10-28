<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Model;

use Aheadworks\BuildifyMobileAddon\Api\BuildifyApiKeyInterface;
use Aheadworks\BuildifyMobileAddon\Model\Service\ConfigStorage;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Psr\Log\LoggerInterface;

/**
 * Class BuildifyApiKey
 */
class BuildifyApiKey implements BuildifyApiKeyInterface
{
    public const CONFIG_STORAGE_PATH = 'aw_buildify_mobile_addon/buildify/keys';
    public const PUBLIC_KEY_PARAM = 'public_api_key';
    public const PRIVATE_KEY_PARAM = 'private_api_key';

    private $keysData = [];

    /**
     * @var ConfigStorage
     */
    private $configStorage;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    /**
     * @var JsonSerializer
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BuildifyApiKey constructor.
     *
     * @param ConfigStorage $configStorage
     * @param EncryptorInterface $encryptor
     * @param JsonSerializer $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        ConfigStorage $configStorage,
        EncryptorInterface $encryptor,
        JsonSerializer $serializer,
        LoggerInterface $logger
    ) {
        $this->configStorage = $configStorage;
        $this->encryptor = $encryptor;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * Get public key
     *
     * @return string|null
     */
    public function getPublicKey(): ?string
    {
        $this->loadKeysData();
        return $this->keysData[self::PUBLIC_KEY_PARAM] ?? null;
    }

    /**
     * Get private key
     *
     * @return string|null
     */
    public function getPrivateKey(): ?string
    {
        $this->loadKeysData();
        return $this->keysData[self::PRIVATE_KEY_PARAM] ?? null;
    }

    /**
     * Save data of keys
     *
     * @param string $publicKey
     * @param string $privateKey
     * @return void
     */
    public function save(string $publicKey, string $privateKey): void
    {
        $data = [self::PRIVATE_KEY_PARAM => $privateKey, self::PUBLIC_KEY_PARAM => $publicKey];

        try {
            $encryptVal = $this->convertArrayToEncryptString($data);
            $this->configStorage->setConfig(self::CONFIG_STORAGE_PATH, $encryptVal);
        } catch (\Exception $ex) {
            $this->logger->error('BuildifyMobileAddon Exception: '
                . $ex->getMessage() . ' - ' . $ex->getTraceAsString());
            return;
        }
        $this->keysData = $data;
    }

    /**
     * Loading keys data from storage
     *
     * @return void
     */
    private function loadKeysData(): void
    {
        if (!$this->keysData) {
            try {
                $encryptString = $this->configStorage->getConfig(self::CONFIG_STORAGE_PATH);
                if ($encryptString) {
                    $this->keysData = $this->convertEncryptStringToArray($encryptString);
                }
            } catch (\Exception $ex) {
                $this->logger->error('BuildifyMobileAddon Exception: '
                    . $ex->getMessage() . ' - ' . $ex->getTraceAsString());
            }
        }
    }

    /**
     * Convert array data to encrypt string
     *
     * @param array $data
     * @return string
     */
    private function convertArrayToEncryptString(array $data): string
    {
        $jsonVal = $this->serializer->serialize($data);
        return $this->encryptor->encrypt($jsonVal);
    }

    /**
     * Convert encrypt string to array
     *
     * @param string $value
     * @return array
     */
    private function convertEncryptStringToArray(string $value): array
    {
        $decryptVal = $this->encryptor->decrypt($value);
        return $this->serializer->unserialize($decryptVal);
    }
}
