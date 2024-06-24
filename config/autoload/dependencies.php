<?php

declare(strict_types=1);

use App\Database\Dependency\DatabaseTransactionDependency;
use App\Domain\Transaction\Dependency\TransactionDependency;
use App\Domain\User\Dependency\UserDependency;
use App\Request\Dependency\RequestDependecy;
use App\Response\Dependency\ResponseDependency;

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
return [
    ...RequestDependecy::getBindings(),
    ...ResponseDependency::getBindings(),
    ...DatabaseTransactionDependency::getBindings(),
    ...TransactionDependency::getBindings(),
    ...UserDependency::getBindings(),
];
