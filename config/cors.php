<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Ensure your API routes are included
    'allowed_methods' => ['*'], // Allow all request methods (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['*'], // Allow requests from any origin
    'allowed_origins_patterns' => [], // Allow any specific patterns if needed
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Set to true only if you need authentication cookies
];
