<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Model\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

/**
 * Class ConfigStorage to manage data of storage
 */
class ConfigStorage
{
    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ConfigEditor constructor.
     *
     * @param WriterInterface $configWriter
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(WriterInterface $configWriter, ScopeConfigInterface $scopeConfig)
    {
        $this->configWriter = $configWriter;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Set config value to storage
     *
     * @param string $path
     * @param string $value
     * @param string $scope
     * @param int $scopeId
     * @return void
     */
    public function setConfig(
        string $path,
        string $value,
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeId = 0
    ) {
        $this->configWriter->save($path, $value, $scope, $scopeId);
    }

    /**
     * Get config value from storage
     *
     * @param string $path
     * @param string $scope
     * @param int|null|string $scopeId
     * @return mixed
     */
    public function getConfig(string $path, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = null)
    {
        return $this->scopeConfig->getValue($path, $scope, $scopeId);
    }
}
