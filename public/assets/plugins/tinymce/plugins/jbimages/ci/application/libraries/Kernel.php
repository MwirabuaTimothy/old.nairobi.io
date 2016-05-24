<?php

class Kernel
{    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->_bootstrap();
    }
    
    /**
     * Perform boostrap operations.
     */
    private function _bootstrap()
    {
        /* We register 3rd party autoloader */
        require APPPATH . '/config/aws.php';
        if($config['s3']['enable']){          
            require APPPATH.'../vendor/autoload.php';
        }

    }

}
