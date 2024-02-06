<?php
/**
 * mcHC - ParseInterface
 *
 * @author Masud Rana
 * @version 0.01
 */

namespace mcHC\http;

interface ParseInterface
{
    /**
     * Parse HTTP response
     * @param Response $res the resulting response
     * @param Request $req the request to be parsed
     * @param string $key the index key of request
     */
    public function parse(Response $res, Request $req, $key);
}
