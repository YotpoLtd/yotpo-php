yotpo-php
=========

A PHP interface to the YOTPO API


## Requirements

* YOTPO API requires PHP 5.3.0 (or later).

## Installation

First clone the repository:

    git clone https://github.com/YotpoLtd/yotpo-php.git

Then download and install the composer dependencies:

    php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
    php composer.phar install

## Usage

First [register your application with Yotpo][register]
Then copy and past the app_key and secret

```php5
// Require composer autoloader
require 'vendor/autoload.php';

use Yotpo\Yotpo;
$ak = "APP_KEY";
$st = "SECRET";
$yotpo = new Yotpo($ak, $st);
```

That's it, you are ready.

Now lets make some public calls to our api. Public calls only require you to use a valid app_key.

Creating your first review using the API

```php5
$yotpo->create_review(array(
      'app_key' => $ak,
      'product_id' => "BLABLA",
      'shop_domain' => "omri.co",
      'product_title' => "pt",
      'product_description' => "pd",
      'product_url' => "http://google.com/?q=myproducturl",
      'product_image_url' => "https://www.google.com/images/srpr/logo4w.png",
      'user_display_name' => "MOSHE5656",
      'user_email' => 'haim@yotpo.com',
      'review_body' => "this is my review body",
      'review_title' => "my review title",
      'review_score' => 5
      ));
```

and now lets retrieve all the reviews of our product BLABLA

```php5

$response = $yotpo->get_product_reviews(array('app_key' => $ak, 'product_id' => "BLABLA"));

echo $response->response->reviews[0]->title;
echo $response->response->reviews[0]->score;
```

getting the bottom line of product BLABLA

```php5
$response = $yotpo->get_product_bottom_line(array('app_key' => $ak, 'product_id' => "BLABLA"));

echo $response->response->bottomline->average_score;
echo $response->response->bottomline->total_reviews;
```

Now lets try something a little bit more complicated. Lets try to create a purchase. 

For that we will need to go through Yotpo authenticaton process, provide an app_key and secret, and return to get the utoken. The utoken will allow us to make authenticated API calls. 

```php5
// retrieving the utoken - will be valid for 24 hours
$credentials = $yotpo->get_oauth_token();
$utoken = $credentials->access_token;

// first creating the products that are in the order, notice that the key of the product hash is the product_sku
$products = array(
        "BLABLA1" => array(
                'url' => "http://shop.yotpo.com/products/amazing-yotpo-poster",
                'name' => "Yotpo Amazing Poster",
                'image_url' => "http://cdn.shopify.com/s/files/1/0098/1912/products/qa2_medium.png?41",
                'description' => "this is the most awesome poster in the world!",
                'price' => "100"
            )
        );


//now we will create a purchase using this the token we have received in the previous step
$response = $yotpo->create_purchase(array(	'app_key' => $ak,
                                        		'utoken' => $utoken,
                                        		'email' => "trial@yotpo.com",
                                        		'customer_name' => "bob",
                                        		'order_id' => "13444",
                                        		'platform' => "Shopify",
                                        		'order_date' => "2013-05-28",
                                        		'products' => $products,
                                        		'currency_iso' => "USD"
                                        		));

```

We can pull all the purchases of a certain account to make sure that the previous calls has worked

```php5
$response = $yotpo->get_purchases(array('app_key' => $ak, 'utoken' => $utoken, 'since_date' => "2013-05-26"));
echo $response->response->total_purchases;
```


[register]: https://www.yotpo.com/register

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
