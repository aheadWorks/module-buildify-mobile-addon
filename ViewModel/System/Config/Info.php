<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\ViewModel\System\Config;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Aheadworks\BuildifyMobileAddon\Model\MobileAppSubscription\Subscription;
use Aheadworks\BuildifyMobileAddon\Api\BuildifyApiKeyInterface;

/**
 * Class Info to display data in template
 */
class Info implements ArgumentInterface
{
    /**
     * @var BuildifyApiKeyInterface
     */
    private $buildifyApiKey;

    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * Info constructor.
     *
     * @param BuildifyApiKeyInterface $buildifyApiKey
     * @param Subscription $subscription
     */
    public function __construct(BuildifyApiKeyInterface $buildifyApiKey, Subscription $subscription)
    {
        $this->buildifyApiKey = $buildifyApiKey;
        $this->subscription = $subscription;
    }

    /**
     * Is mobile buildify keys active
     *
     * @return bool
     */
    public function isMobileBuildifyKeysActive(): bool
    {
        return $this->subscription->getManager()->isSubscriptionActive() && $this->buildifyApiKey->getPublicKey();
    }
}
