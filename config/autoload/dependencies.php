<?php

declare(strict_types=1);

use App\Database\Dependency\DatabaseTransactionDependency;
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
];
