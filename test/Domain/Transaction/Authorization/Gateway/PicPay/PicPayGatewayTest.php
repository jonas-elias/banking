<?php

declare(strict_types=1);

namespace HyperfTest\Domain\Transaction\Authorization\Gateway\PicPay;

use App\Constants\HttpStatus;
use App\Domain\Transaction\Authorization\Gateway\PicPay\PicPayGateway;
use App\Domain\Transaction\DTO\TransactionDTO;
use App\Domain\Transaction\Exception\AuthorizationException;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\ClientFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class PicPayGatewayTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testAuthorizeSuccessful(): void
    {
        $configMock = Mockery::mock(ConfigInterface::class);
        $clientFactoryMock = Mockery::mock(ClientFactory::class);
        $clientMock = Mockery::mock(Client::class);

        $transactionDTO = new TransactionDTO();
        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $configMock->shouldReceive('get')
            ->once()
            ->with('authorization.gateway.picpay.uri')
            ->andReturn('http://example.com');

        $clientFactoryMock->shouldReceive('create')
            ->once()
            ->andReturn($clientMock);

        $clientMock->shouldReceive('get')
            ->once()
            ->with('http://example.com', [
                'json' => [
                    'payer_id' => 'payer_id',
                    'payee_id' => 'payee_id',
                    'value' => 100,
                ],
                'http_errors' => false,
            ])
            ->andReturn(new Response(HttpStatus::OK));

        $gateway = new PicPayGateway($configMock, $clientFactoryMock);
        $gateway->authorize($transactionDTO);

        $this->assertTrue(true);
    }

    public function testAuthorizeFailure(): void
    {
        $configMock = Mockery::mock(ConfigInterface::class);
        $clientFactoryMock = Mockery::mock(ClientFactory::class);
        $clientMock = Mockery::mock(Client::class);

        $transactionDTO = new TransactionDTO();
        $transactionDTO->payer = 'payer_id';
        $transactionDTO->payee = 'payee_id';
        $transactionDTO->value = 100;

        $configMock->shouldReceive('get')
            ->once()
            ->with('authorization.gateway.picpay.uri')
            ->andReturn('http://example.com');

        $clientFactoryMock->shouldReceive('create')
            ->once()
            ->andReturn($clientMock);

        $clientMock->shouldReceive('get')
            ->once()
            ->with('http://example.com', [
                'json' => [
                    'payer_id' => 'payer_id',
                    'payee_id' => 'payee_id',
                    'value' => 100,
                ],
                'http_errors' => false,
            ])
            ->andReturn(new Response(HttpStatus::INTERNAL_SERVER_ERROR));

        $this->expectException(AuthorizationException::class);

        $gateway = new PicPayGateway($configMock, $clientFactoryMock);
        $gateway->authorize($transactionDTO);
    }
}
