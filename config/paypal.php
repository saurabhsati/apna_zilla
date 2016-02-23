<?php
return array(
    // set your paypal credential
    'client_id' => 'AV2kbYOwsga_37DiEybRI7kQprodd5erP4SvAieGMnRE6bBTph5Dl8STv9WUB2Yki0_yh__eSjMqMY7w',
    'secret' => 'EImTBWVa6ZyH2k7wm3jJf7aXpoInq7YnbKnKjavM0PK0oPnRjwRY8n_Z4gZcM5QGPDYS6scJoCeVRrPR',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
