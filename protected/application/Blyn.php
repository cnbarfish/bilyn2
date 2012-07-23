<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blyn
 *
 * @author jianfeng
 */
class Blyn {
    
    private static $app;
    private static $util;
    
    /**
	 * Returns the application singleton, null if the singleton has not been created yet.
	 * @return BApplication the application singleton, null if the singleton has not been created yet.
	 */
    public static function app()
    {
        if(self::$app == null)
        {
            self::$app = new BApplication();
        }
        
        return self::$app;
    }
    
      /**
	 * Returns the application singleton, null if the singleton has not been created yet.
	 * @return BUtil the application singleton, null if the singleton has not been created yet.
	 */
    public static function util()
    {
         if(self::$util == null)
        {
            self::$util = new BUtil();
        }
        
        return self::$util;
    }
}

?>
