<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Plugin\AwBuildify\Model\Api\Request;

use Aheadworks\Buildify\Model\Api\Request\Curl as Subject;
use Aheadworks\BuildifyMobileAddon\Api\BuildifyApiKeyInterface;
use Aheadworks\BuildifyMobileAddon\Model\MobileAppSubscription\Subscription;

/**
 * Class CurlPlugin for replace buildify keys
 */
class CurlPlugin
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
     * CurlPlugin constructor.
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
     * Set Buildify mobile keys
     *
     * @param Subject $subject
     * @param string $url
     * @param array $params
     * @param string $method
     * @return array
     */
    public function beforeRequest(Subject $subject, $url, $params, $method)
    {
        if (isset($params['public_api_key']) && $this->subscription->getManager()->isSubscriptionActive() &&
            $this->buildifyApiKey->getPublicKey()) {
            $params['public_api_key'] = $this->buildifyApiKey->getPublicKey();
            $params['private_api_key'] = $this->buildifyApiKey->getPrivateKey();
        }
        return [$url, $params, $method];
    }
}
