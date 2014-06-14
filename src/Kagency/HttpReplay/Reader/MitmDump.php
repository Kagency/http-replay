<?php

namespace Kagency\HttpReplay\Reader;

use Kagency\HttpReplay\Reader;
use Kagency\HttpReplay\Interaction;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MitmDump extends Reader
{
    /**
     * Decoder
     *
     * @var TNetstring_Decoder
     */
    private $decoder;

    /**
     * __construct
     *
     * @param mixed \TNetstring_Decoder $decoder = null
     * @return void
     */
    public function __construct(\TNetstring_Decoder $decoder = null)
    {
        $this->decoder = $decoder ?: new \TNetstring_Decoder();
    }

    /**
     * Read interactions l
     *
     * @param string $file
     * @return Interaction[]
     */
    public function readInteractions($file)
    {
        return array_map(
            function (array $interaction) {
                return new Interaction(
                    Request::create(
                        $interaction['request']['path'],
                        $interaction['request']['method'],
                        array(),
                        array(),
                        array(),
                        $this->mapHeaders($interaction['request']['headers']),
                        $interaction['request']['content']
                    ),
                    Response::create(
                        $interaction['response']['content'],
                        $interaction['response']['code'],
                        $this->mapHeaders($interaction['response']['headers'], '')
                    )
                );
            },
            $this->decoder->decode(file_get_contents($file))
        );
    }

    /**
     * Map headers
     *
     * Maps HTTP headers from the real names to the naems PHP would use in the
     * SERVER array, so that Symfony2 can map them back.
     *
     * @param array $headers
     * @return array
     */
    protected function mapHeaders(array $headers, $prefix = 'HTTP_')
    {
        $phpHeaders = array();
        foreach ($headers as $headerPair) {
            list($name, $value) = $headerPair;
            $phpHeaders[$prefix . str_replace('-', '_', strtoupper($name))] = $value;
        }

        return $phpHeaders;
    }
}
