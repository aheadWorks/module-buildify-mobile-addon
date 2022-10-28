<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Plugin\AwBuildify\Model;

use Aheadworks\Buildify\Model\Config as Subject;
use Aheadworks\MobileAppConnector\Api\Data\HomepageInterface;
use Aheadworks\BuildifyMobileAddon\Model\MobileAppSubscription\Subscription;

/**
 * Class ConfigPlugin to mobile app connector setting
 */
class ConfigPlugin
{
    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * ConfigPlugin constructor.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Turns on buildify for mobile app connector entity type according mobile subscription
     *
     * @param Subject $subject
     * @param callable $proceed
     * @param string $type
     * @param int|null $storeId
     * @return bool
     */
    public function aroundIsEnabledForEntityType(
        Subject $subject,
        callable $proceed,
        string $type,
        int $storeId = null
    ): bool {
        return $type === HomepageInterface::AW_MOBILEAPPCONNECTOR_HOMEPAGE_CONTENT
        && $this->subscription->getManager()->isSubscriptionActive() ?: $proceed($type, $storeId);
    }
}
