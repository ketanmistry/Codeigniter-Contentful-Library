<?php
/*
|--------------------------------------------------------------------------
| Contentful Library
|--------------------------------------------------------------------------
|
| Library to get content from Contentful.com.
|
| V1.0
| Copyright (c) 2018 Ketan Mistry (https://iamketan.com.au)
| Licensed under the MIT license:
|  - http://www.opensource.org/licenses/mit-license.php
|
*/
class Contentful {

    function __construct() {
        // Space Id
        $this->space_id = '';

        // Content Delivery (Published) Token
        $this->access_token = '';

        // Content Preview (Draft) Token
        $this->access_token_preview = '';

        // Endpoint for Content Delivery (Published)
        $this->base_url = sprintf('https://cdn.contentful.com/spaces/%s/', $this->space_id);

        // Endpoint for Content Preview (Draft)
        $this->base_url_preview = sprintf('https://preview.contentful.com/spaces/%s/', $this->space_id);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Content
    |--------------------------------------------------------------------------
    |
    | Single function to return JSON content from Contentful API.
    |
    | @param $method (string) - E.g. 'entries', 'entry', 'assets' etc
    | @param $params (array) - Array of parameters to pass as url queries
    | @param $preview (bool) - If true, uses the preview endpoint
    |
    */
    public function get($method=false, $params=array(), $preview=false) {

        if ($method !== false) {

            // If $preview is set to true, use the content preview endpoint
            // and preview access token
            if ($preview === true) {
                $this->base_url = $this->base_url_preview;
                $this->access_token = $this->access_token_preview;
            }

            // Add the access_token to the endpoint
            $url_params = sprintf('?access_token=%s', $this->access_token);

            if (!empty($params) && is_array($params)) {
                $url_params .= '&'.http_build_query($params);
            }

            $endpoint = sprintf('%s%s/%s', $this->base_url, $method, $url_params);
            $response = file_get_contents($endpoint);

            if (!empty($response)) {
                $data = json_decode($response, true);
                return $data;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Get Entry
    |--------------------------------------------------------------------------
    |
    | Returns content for the passed entry (url handle).
    |
    | @param $content_type (string) - As set in Contentful
    | @param $handle (string) - URL handle/slug of the entry to return
    | @param $preview (bool) - If true, will use the content preview endpoint
    |
    */
    public function get_entry($content_type, $handle, $preview=false) {

        $params = array(
            'content_type' => $content_type,
            'fields.urlHandle' => $handle
        );

        $response = $this->get('entries', $params, $preview);

        if (!empty($response['items'])) {
            return $response['items'][0]['fields'];
        } else {
            return false;
        }

    }

}
