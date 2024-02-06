<?php
/**
 * mcHC - Response
 *
 * @author Masud Rana
 * @version 0.01
 */

namespace mcHC\http;

class Response
{
    use HeaderTrait;
    /**
     * @var integer response status code
     */
    public $status;
    /**
     * @var string response status line, such as 'Not Found', 'Forbidden' ...
     */
    public $statusText;
    /**
     * @var string error message, null if has not error.
     */
    public $error;
    /**
     * @var string response body content.
     */
    public $body;
    /**
     * @var float time cost to complete this request.
     */
    public $timeCost;
    /**
     * @var string raw request url.
     */
    public $url;
    /**
     * @var integer number of redirects
     */
    public $numRedirected = 0;

    /**
     * Constructor
     * @param string $url
     */
    public function __construct($url)
    {
        $this->reset();
        $this->url = $url;
    }

    /**
     * Convert to string (body)
     * @return string
     */
    public function __toString()
    {
        return $this->body;
    }

    /**
     * Check has error or not
     * @return bool
     */
    public function hasError()
    {
        return $this->error !== null;
    }

    /**
     * Reset object
     */
    public function reset()
    {
        $this->status = 400;
        $this->statusText = 'Bad Request';
        $this->body = '';
        $this->error = null;
        $this->timeCost = 0;
        $this->clearHeader();
        $this->clearCookie();
    }

    /**
     * Redirect to another url
     * This method can be used in request callback.
     * @param string $url target url to be redirected to.
     */
    public function redirect($url)
    {
        // has redirect from upstream
        if (($this->status === 301 || $this->status === 302) && ($this->hasHeader('location'))) {
            return;
        }
        // @fixme need a better solution
        $this->numRedirected--;
        $this->status = 302;
        $this->setHeader('location', $url);
    }

    /**
     * Get json response data
     * @return mixed
     */
    public function getJson()
    {
        if (stripos($this->getHeader('content-type'), '/json') !== false) {
            return json_decode($this->body, true);
        } else {
            return false;
        }
    }
}
