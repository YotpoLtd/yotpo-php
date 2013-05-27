<?php

/**
 * @author Vladislav Shub <vlad@yotpo.com>
 */

namespace Yotpo\Test;


require(dirname(dirname(dirname(__FILE__))) . '/bootstrap.php');
\Yotpo\Bootstrap::init();

class YotpoTest extends \PHPUnit_Framework_TestCase {

    const TEST_APP_KEY = 'nNgGNA54ETOqaXQ7hRZymxqdtwwetJKDVs0v8qGG';
    const TEST_SECRET = 'YUFV3FrFHGbAJLPsOR8JebwUUhGJg9Z42XKj3Umm';

    private $utoken = null;

    function testInit() {
        $yotpo = new \Yotpo\Yotpo(self::TEST_APP_KEY, self::TEST_SECRET);
        $this->assertEquals('Yotpo\Yotpo', get_class($yotpo));
    }

    public function testGetOauthToken(){
        $yotpo = new \Yotpo\Yotpo(self::TEST_APP_KEY, self::TEST_SECRET);
        $credentials = $yotpo->get_oauth_token();
        $this->assertObjectHasAttribute('access_token', $credentials);
        $this->assertObjectHasAttribute('token_type', $credentials);
    }

}

?>
