<?php
declare(strict_types=1);

namespace Aheadworks\BuildifyMobileAddon\Test\Unit\Setup\Patch\Data;

use Aheadworks\BuildifyMobileAddon\Api\BuildifyApiKeyInterface;
use Aheadworks\BuildifyMobileAddon\Setup\Patch\Data\TrialPeriodInitializationPatch;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

/**
 * Class TrialPeriodInitializationPatchTest
 */
class TrialPeriodInitializationPatchTest extends TestCase
{
    /**
     * @var TrialPeriodInitializationPatch
     */
    private $trialPeriodInitializationPatch;

    /**
     * @var BuildifyApiKeyInterface|MockObject
     */
    private $buildifyApiKeyMock;

    /**
     * @var ObjectManagerHelper
     */
    private $objectManagerHelper;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->buildifyApiKeyMock = $this->createMock(BuildifyApiKeyInterface::class);
        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->trialPeriodInitializationPatch =  $this->objectManagerHelper->getObject(
            TrialPeriodInitializationPatch::class,
            [
                'buildifyApiKey' => $this->buildifyApiKeyMock
            ]
        );
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->trialPeriodInitializationPatch, $this->buildifyApiKeyMock);
    }

    /**
     * Testing of return value of execute method
     */
    public static function testGetDependenciesResult(): void
    {
        parent::assertSame([], TrialPeriodInitializationPatch::getDependencies());
    }

    /**
     * Testing of return value of execute method
     */
    public function testGetAliasesResult(): void
    {
        $this->assertSame([], $this->trialPeriodInitializationPatch->getAliases());
    }

    /**
     * Testing of return value of execute method
     */
    public function testApplyResult(): void
    {
        $this->buildifyApiKeyMock
            ->method('save')
            ->with(
                TrialPeriodInitializationPatch::BUILDIFY_PUBLIC_API_KEY,
                TrialPeriodInitializationPatch::BUILDIFY_PRIVATE_API_KEY
            )->willReturnSelf();

        $this->assertSame($this->trialPeriodInitializationPatch, $this->trialPeriodInitializationPatch->apply());
    }
}
