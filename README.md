# Contentful Library for CodeIgniter

This library is built for CodeIgniter 3+ (it should also work with version 2+, but is untested).

## How to use
Save the `Contentful.php` file to your `applications/libraries` folder and add your space ID and tokens within the construct() - you can split this out in to a separate config file if you prefer.

Your contentful entries must have a field named `urlHandle`. This is what is used to return the correct entry.

All methods are called using the usual CodeIgniter syntax, for example:

```
$this->contentful->get('entries');
```

## Author
[Ketan Mistry](https://iamketan.com.au) ([@ketanumistry](https://twitter.com/ketanumistry))

## License

This library is available under the MIT license.
