<?php
file_put_contents(
    __DIR__ . '/cron_working.log',
    date('Y-m-d H:i:s') . " - cron executed\n",
    FILE_APPEND
);
