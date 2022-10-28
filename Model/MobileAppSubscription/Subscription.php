<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Model\MobileAppSubscription;

use Aheadworks\MobileAppSubscription\Api\SubscriptionManagerInterface;

/**
 * Class Subscription by MobileAppSubscription module
 */
class Subscription
{
    /**
     * @var SubscriptionManagerInterface
     */
    private $subscriptionManager;

    /**
     * Manager constructor.
     *
     * @param SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(SubscriptionManagerInterface $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * Get subscription manager from MobileAppSubscription
     *
     * @return SubscriptionManagerInterface
     */
    public function getManager(): SubscriptionManagerInterface
    {
        return $this->subscriptionManager;
    }
}
