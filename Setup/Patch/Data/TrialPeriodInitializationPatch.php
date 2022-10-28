<?php
namespace Aheadworks\BuildifyMobileAddon\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Aheadworks\BuildifyMobileAddon\Api\BuildifyApiKeyInterface;

/**
 * Trial period initialization
 */
class TrialPeriodInitializationPatch implements DataPatchInterface
{
    public const BUILDIFY_PUBLIC_API_KEY = '$2y$13$TiowK9MceEFR89wG3F8t4Om/yo71wA9LNTSC0D8QUAysPR4yfWV8m';
    public const BUILDIFY_PRIVATE_API_KEY = '$2y$13$.xxX6QdF0ns2i22ohG4sK.B8.MGwOXWaR5glKhN/uMnHA6SB.lDYe';

    /**
     * @var BuildifyApiKeyInterface
     */
    private $buildifyApiKey;

    /**
     * TrialPeriodInitializationPatch constructor.
     *
     * @param BuildifyApiKeyInterface $buildifyApiKey
     */
    public function __construct(
        BuildifyApiKeyInterface $buildifyApiKey
    ) {
        $this->buildifyApiKey = $buildifyApiKey;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Run code inside patch
     *
     * @return $this
     */
    public function apply()
    {
        $this->buildifyApiKey->save(self::BUILDIFY_PUBLIC_API_KEY, self::BUILDIFY_PRIVATE_API_KEY);
        return $this;
    }
}
