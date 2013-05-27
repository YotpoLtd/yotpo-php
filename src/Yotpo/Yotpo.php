<?php

namespace Yotpo;

require(dirname(dirname(dirname(__FILE__))) . '/bootstrap.php');

use Httpful\Request;
use Httpful\Mime;
use Httpful\Response;

/**
 * Yotpo PHP inetrface for api.yotpo.com
 *
 * @author vlad
 */
class Yotpo {

    const VERSION = '0.0.1';

    protected static $app_key, $secret, $base_uri = 'https://api.yotpo.com';

    public function __construct($app_key = null, $secret = null, $base_uri = null) {
        if ($app_key != null) {
            self::$app_key = $app_key;
        }

        if ($secret != null) {
            self::$secret = $secret;
        }

        if ($base_uri != null) {
            self::$base_uri = $base_uri;
        }

        $template = Request::init()
                ->withoutStrictSsl()        // Ease up on some of the SSL checks
                ->expectsJson()             // Expect JSON responses
                ->sendsType(Mime::JSON)
                ->addHeader('yotpo_api_connector', 'PHP-' . Yotpo::VERSION);

        // Set it as a template
        Request::ini($template);
    }

    protected function get($uri, array $params = null) {
        $params = array_filter($params, 'strlen');
        return self::process_response(Request::get(self::$base_uri . $uri . http_build_query($params))->send());
    }

    protected function post($uri, array $params = null) {
        $params = array_filter($params, 'strlen');
        return self::process_response(Request::get(self::$base_uri . $uri)->body($params)->send());
    }

    protected function put($uri, array $params = null) {
        $params = array_filter($params, 'strlen');
        return self::process_response(Request::post(self::$base_uri . $uri)->body($params)->send());
    }

    protected function delete($uri, array $params = null) {
        $params = array_filter($params, 'strlen');
        return self::process_response(Request::delete(self::$base_uri . $uri . http_build_query($params))->send());
    }

    protected static function process_response(Response $response) {
        if($response->hasBody()){
            return $response->body;
        }else{
            throw 'Invalid Response';
        }
    }

    public function create_user(array $user_hash) {
        $user = array(
            'email' => $user_hash['email'],
            'display_name' => $user_hash['display_name'],
            'first_name' => $user_hash['first_name'],
            'last_name' => $user_hash['last_name'],
            'website_name' => $user_hash['website_name'],
            'password' => $user_hash['password'],
            'support_url' => $user_hash['support_url'],
            'callback_url' => $user_hash['callback_url'],
            'url' => $user_hash['url']
        );
        return $this->post('/users', array(user => $user));
    }

    public function get_oauth_token(array $credentials_hash = array()) {
        $request = array(
            'grant_type' => 'client_credentials'
        );

        if (array_key_exists('client_id', $credentials_hash)) {
            $request['client_id'] = $credentials_hash['client_id'];
        } else {
            $request['client_id'] = self::$app_key;
        }

        if (array_key_exists('secret', $credentials_hash)) {
            $request['client_secret'] = $credentials_hash['secret'];
        } else {
            $request['client_secret'] = self::$secret;
        }

        return $this->post('/oauth/token', $request);
    }

    public function create_account_platform(array $account_platform_hash) {
        
    }

    public function get_login_url(array $credentials_hash = null) {
        $request = array();

        if (array_key_exists('app_key', $credentials_hash)) {
            $request['app_key'] = $credentials_hash['app_key'];
        } else {
            $request['app_key'] = self::$app_key;
        }

        if (array_key_exists('secret', $credentials_hash)) {
            $request['secret'] = $credentials_hash['secret'];
        } else {
            $request['secret'] = self::$secret;
        }

        return $this->get('/users/b2blogin.json', $request);
    }

    public function check_subdomain(array $subdomain_hash) {
        
    }

    public function update_account(array $account_hash) {
        
    }

    public function create_purchase(array $purchase_hash) {
        
    }

    public function create_purchases(array $purchases_hash) {
        
    }

    public function get_purchases(array $request_hash) {
        
    }

    public function send_test_reminder(array $reminder_hash) {
      $request = self::build_request(array('utoken', 'email'), $reminder_hash);
      $app_key = $reminder_hash['app_key'];
      $this->post("/apps/$app_key/reminders/send_test_email", $request);
        
    }

    public function get_all_bottom_lines(array $request_hash) {
        
    }

    public function create_review(array $review_hash) {
        $params = array(
            'app_key' => 'appkey',
            'product_id' => 'sku',
            'domain' => 'shop_domain',
            'product_title' => 'product_title',
            'product_description' => 'product_description',
            'product_url' => 'product_url',
            'product_image_url' => 'product_image_url',
            'display_name' => 'user_display_name',
            'email' => 'user_email',
            'review_content' => 'review_body',
            'review_title' => 'review_title',
            'review_score' => 'review_score',
            'utoken' => 'utoken'
        );
        $request = self::build_request($params, $review_hash);

        $this->get('/reviews/dynamic_create', $request);
    }

    public function get_product_reviews(array $request_hash) {
        $app_key = self::$app_key;

        if ($request_hash['app_key']) {
            $app_key = $request_hash['app_key'];
        } else if (!$app_key) {
            throw 'app_key is mandatory for this request';
        }

        $product_id = $request_hash['product_id'];

        if (!$product_id) {
            throw 'product_id is mandatory for this request';
        }

        $request_params = array(
            'page' => $request_hash['page'],
            'count' => $request_hash['count'],
            'since_date' => $request_hash['since_date']
        );

        return $this->get("/products/$app_key/$product_id/reviews", $request_params);
    }

    public function get_product_bottom_line(array $request_hash) {
        $app_key = self::$app_key;

        if ($request_hash['app_key']) {
            $app_key = $request_hash['app_key'];
        } else if (!$app_key) {
            throw 'app_key is mandatory for this request';
        }

        $product_id = $request_hash['product_id'];

        if (!$product_id) {
            throw 'product_id is mandatory for this request';
        }
        return $this->get("/products/$app_key/$product_id/bottomline");
    }

    protected static function build_request(array $params, array $request_params) {
        $request = array();
        foreach ($params as $key => $value) {
            if (array_key_exists($key, $request_params)) {
                $request[$value] = $request_params[$key];
            }
        }
    }

}

?>
