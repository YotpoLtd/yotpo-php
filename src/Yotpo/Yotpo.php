<?php
namespace Yotpo;
/**
 * Yotpo PHP inetrface for api.yotpo.com
 *
 * @author vlad
 */
class Yotpo {
    const VERSION = '0.0.1';
    
    protected static $app_key, $secret, $base_uri = 'https://api.yotpo.com';
    
    public function __construct(String $app_key = null, String $secret = null, String $base_uri = null){
        if($app_key != null){
            self::$app_key = $app_key;
        }
        
        if($secret != null){
            self::$secret = $secret;
        }
        
        if($base_uri != null){
            self::$base_uri = $base_uri;
        }
        
        $template = Request::init()
                        ->withoutStrictSsl()        // Ease up on some of the SSL checks
                        ->expectsJson()             // Expect JSON responses
                        ->sendsType(Mime::JSON)
                        ->addHeader('yotpo_api_connector', 'PHP-'.Yotpo::VERSION);
        
        // Set it as a template
        Request::ini($template);
    }
    
    protected function get(String $uri, $params = null){
        $params = array_filter($params, 'strlen');
        return Request::get( $this->base_uri.$uri.http_build_query($params))->send();
    }
    
    protected function post(String $uri, $params = null){
        $params = array_filter($params, 'strlen');
        return Request::get( $this->base_uri.$uri)
                ->body($params)->send();
    }
    
    protected function put(String $uri, $params = null){
        $params = array_filter($params, 'strlen');
        return Request::post( $this->base_uri.$uri)
                ->body($params)->send();
    }
    
    protected function delete(String $uri, $params = null){
        $params = array_filter($params, 'strlen');
        return Request::delete($this->base_uri.$uri.http_build_query($params))->send();
    }
    
    public function create_user(array $user_hash){
        
    }
    
    public function get_oauth_token(array $credentials_hash = null){
        
    }
    
    public function create_account_platform(array $account_platform_hash){
        
    }
    
    public function get_login_url(array $credentials_hash = null){
        
    }
    
    public function check_subdomain(array $subdomain_hash){
        
    }
    
    public function update_account(array $account_hash){
        
    }
    
    public function create_purchase(array $purchase_hash){
        
    }
    
    public function create_purchases(array $purchases_hash){
        
    }
    
    public function get_purchases(array $request_hash){
        
    }
    
    public function send_test_reminder(array $reminder_hash){
        
    }
    
    public function get_all_bottom_lines(array $request_hash){
        
    }
    
    public function create_review(array $review_hash){
        
    }
    
    public function get_product_review(array $request_hash){
        $app_key = self::$app_key;
        
        if($request_hash['app_key']){
            $app_key = $request_hash['app_key'];
        }else if(!$app_key){
            throw 'app_key is mandatory for this request';
        }
        
        $product_id = $request_hash['product_id'];
        
        if(!$product_id){
            throw 'product_id is mandatory for this request';
        }
        
        $request_params = array(
            'page' => $request_hash['page'],
            'count' => $request_hash['count'],
            'since_date' => $request_hash['since_date']
        );
        
        return $this->get("/products/$app_key/$product_id/reviews", $request_params);
    }
    
    public function get_product_bottom_line(array $request_hash){
        $app_key = self::$app_key;
        
        if($request_hash['app_key']){
            $app_key = $request_hash['app_key'];
        }else if(!$app_key){
            throw 'app_key is mandatory for this request';
        }
        
        $product_id = $request_hash['product_id'];
        
        if(!$product_id){
            throw 'product_id is mandatory for this request';
        }
        return $this->get("/products/$app_key/$product_id/bottomline");
    }
}

?>
