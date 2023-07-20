<?php

declare(strict_types=1);

namespace DotTest\ResponseHeader;

use Dot\ResponseHeader\Factory\ResponseHeaderMiddlewareFactory;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ResponseHeaderMiddlewareFactoryTest extends TestCase
{
    private ResponseHeaderMiddlewareFactory $responseHeaderMiddlewareFactory;

    private ContainerInterface|MockObject $containerInterface;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->responseHeaderMiddlewareFactory = new ResponseHeaderMiddlewareFactory();
        $this->containerInterface              = $this->createMock(ContainerInterface::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws Exception
     * @throws NotFoundExceptionInterface
     */
    public function testWillNotCreateApplicationWithoutConfig(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(false);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(ResponseHeaderMiddlewareFactory::MESSAGE_MISSING_CONFIG);
        (new ResponseHeaderMiddlewareFactory())($container);
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillNotCreateApplicationWithoutPackageConfig(): void
    {
        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn([
                'test',
            ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(ResponseHeaderMiddlewareFactory::MESSAGE_MISSING_PACKAGE_CONFIG);
        (new ResponseHeaderMiddlewareFactory())($container);
    }
}
