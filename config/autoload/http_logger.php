<?php

declare(strict_types=1);

use App\HttpLogger\LogWriter;
use FriendsOfHyperf\Http\Logger;

use function Hyperf\Support\env;

return [
    'log_profile' => Logger\Profile\DefaultLogProfile::class,

    'log_writer' => LogWriter::class,

    'log_group' => 'http-logger',

    'log_name' => env('HTTP_LOGGER_LOG_NAME', 'http'),

    'log_level' => 'debug',

    'log_format' => "%host% %remote_addr% [%time_local%] \"%request%\" %status% %body_bytes_sent% %trace_id% %http_referer% %http_user_agent% %http_x_forwarded_for% %request_time% %upstream_response_time% %upstream_addr%\n",

    'log_time_format' => 'd/M/Y:H:i:s O',
];
