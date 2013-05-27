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

    public function test_get_oauth_token() {
        $yotpo = new \Yotpo\Yotpo(self::TEST_APP_KEY, self::TEST_SECRET);
        $credentials = $yotpo->get_oauth_token();
        $this->assertObjectHasAttribute('access_token', $credentials);
        $this->assertObjectHasAttribute('token_type', $credentials);
    }

    public function test_create_user() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_create_account_platform() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_get_login_url() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_check_subdomain() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_update_account() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_create_purchase() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_create_purchases() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_get_purchases() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_send_test_reminder() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_get_all_bottom_lines() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_create_review() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_get_product_reviews() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_get_product_bottom_line() {
        $this->fail('Not Yet Implemented Test');
    }

    public function test_build_request() {
        $this->fail('Not Yet Implemented Test');
    }

}

?>
