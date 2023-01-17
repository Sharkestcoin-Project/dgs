<?php

return [
    'default' => [
        'locale' => env('DEFAULT_LANG', config('app.locale'))
    ],
    'queue' => [
        'mail' => env('QUEUE_MAIL', false)
    ],
    'kyc' => [
        'must_verified' => env('KYC_MUST_VERIFIED', false),
        'min_day' => env('KYC_MUST_VERIFIED_MIN_DAY', 7),
    ],
    'dotenv' => [
        'pathToEnv'       => base_path('.env'),
        'backupPath'      => resource_path('backups/dotenv/'),
        'filePermissions' => env('FILE_PERMISSIONS', 0755),
    ],
    'users' => [
        'force_to_purchase_plan' => env('FORCE_USER_TO_PURCHASE_PLAN', true),
        'unsubscribe_after_days' => env('UNSUBSCRIBE_AFTER_DAYS', 3),
    ],
    'notification_send_to_email' => env('NOTIFICATION_SEND_TO_EMAIL', false),
];
