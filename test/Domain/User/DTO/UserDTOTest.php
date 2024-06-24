<?php

declare(strict_types=1);

namespace HyperfTest\Domain\User\DTO;

use App\Domain\User\DTO\UserDTO;
use App\DTO\Cast\IntegerConversionCast;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class UserDTOTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testUserDTOInitialization()
    {
        $userDTO = new UserDTO([
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 1000,
            'type' => 'common',
        ]);

        $this->assertEquals('John Doe', $userDTO->name);
        $this->assertEquals('12345678900', $userDTO->document);
        $this->assertEquals('john.doe@example.com', $userDTO->email);
        $this->assertEquals('password123', $userDTO->password);
        $this->assertEquals(1000, $userDTO->balance);
        $this->assertEquals('common', $userDTO->type);
    }

    public function testUserDTOHashPassword()
    {
        $userDTO = new UserDTO([
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 1000,
            'type' => 'common',
        ]);

        $hashedPassword = $userDTO->hashPassword();
        $this->assertTrue(password_verify('password123', $hashedPassword));
    }

    public function testUserDTOValidationMessages()
    {
        $dto = new UserDTO([
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 1000.0,
            'type' => 'common',
        ]);

        $messages = $dto->messages();
        $expectedMessages = [
            'name.required'     => 'The name field is required.',
            'name.string'       => 'The name field must be a string.',
            'document.required' => 'The document field is required.',
            'document.string'   => 'The document field must be a string.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email field must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.string'   => 'The password field must be a string.',
            'password.min'      => 'The password field must be at least 8 characters.',
            'balance.required'  => 'The balance field is required.',
            'balance.integer'   => 'The balance field must be an integer value.',
            'balance.min'       => 'The balance field must be at least 0.',
            'type.required'     => 'The type field is required.',
            'type.in'           => 'The type field must be either "common" or "merchant".',
        ];

        $this->assertEquals($expectedMessages, $messages);
    }

    public function testUserDTOValidationRules()
    {
        $userDTO = new UserDTO([
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 1000.0,
            'type' => 'common',
        ]);
        $reflection = new ReflectionClass($userDTO);
        $method = $reflection->getMethod('rules');
        $method->setAccessible(true);
        $rules = $method->invoke($userDTO);

        $expectedRules = [
            'name'     => ['required', 'string'],
            'document' => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'balance'  => ['required', 'integer', 'min:0'],
            'type'     => ['required', 'in:common,merchant'],
        ];

        $this->assertEquals($expectedRules, $rules);
    }

    public function testUserDTOCasts()
    {
        $userDTO = new UserDTO([
            'name' => 'John Doe',
            'document' => '12345678900',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'balance' => 10.0,
            'type' => 'common',
        ]);

        $reflection = new ReflectionClass($userDTO);
        $method = $reflection->getMethod('casts');
        $method->setAccessible(true);
        $casts = $method->invoke($userDTO);

        $this->assertArrayHasKey('balance', $casts);
        $this->assertInstanceOf(IntegerConversionCast::class, $casts['balance']);
        $this->assertSame(1000, $userDTO->balance);
    }
}
