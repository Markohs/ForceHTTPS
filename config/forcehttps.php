<?php

return [

    /*
     * Array of environments were this middleware is *ENABLED*
     * Default: ['stage', 'prod','production']
     */

    'envs_enabled' => ['stage', 'prod', 'production'],

    /*
     * Set up a array of simple text patterns wich will be EXCLUDED from URL redirection, matched in regexp fashion
     * example: ['api/example','cookie-notice']
     * Default: none
     */

    'whitelist_url' => [],

    /*
     * Autoregister (push) in these middleware groups
     * example ['web','api']
     * Default: none
     */

    'autoregister' => [],

];
