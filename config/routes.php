<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 *
 * @document https://hyperf.wiki
 *
 * @contact  group@hyperf.io
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Domain\Transaction\Controller\TransactionController;
use App\Domain\User\Controller\UserController;
use Hyperf\HttpServer\Router\Router;

Router::post('/api/user', [UserController::class, 'register']);
Router::post('/api/transfer', [TransactionController::class, 'transfer']);
