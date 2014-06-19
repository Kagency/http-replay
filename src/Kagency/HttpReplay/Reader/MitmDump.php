<?php

namespace Kagency\HttpReplay\Reader;

use Kagency\HttpReplay\Reader;
use Kagency\HttpReplay\MessageHandler;
use Kagency\HttpReplay\Interaction;
use Kagency\HttpReplay\SimplifiedRequest;
use Kagency\HttpReplay\SimplifiedResponse;

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
     * Message handler
     *
     * @var MessageHandler
     */
    private $messageHandler;

    /**
     * __construct
     *
     * @param mixed \TNetstring_Decoder $decoder = null
     * @return void
     */
    public function __construct(MessageHandler $messageHandler, \TNetstring_Decoder $decoder = null)
    {
        $this->messageHandler = $messageHandler;
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
                    $this->messageHandler->convertFromRequest(
                        new SimplifiedRequest(
                            $interaction['request']['method'],
                            $interaction['request']['path'],
                            $this->mapHeaders($interaction['request']['headers']),
                            $interaction['request']['content']
                        )
                    ),
                    $this->messageHandler->convertFromResponse(
                        new SimplifiedResponse(
                            $interaction['request']['path'],
                            $interaction['response']['code'],
                            $this->mapHeaders($interaction['response']['headers']),
                            $interaction['response']['content']
                        )
                    )
                );
            },
            $this->decoder->decode(file_get_contents($file))
        );
    }

    /**
     * Map headers
     *
     * Map headers to a key values array. This ignores the seldom case of
     * double headers for the sake of simplicity.
     *
     * @param array $headers
     * @return array
     */
    protected function mapHeaders(array $headers)
    {
        $mappedHeaders = array();
        foreach ($headers as $headerPair) {
            list($name, $value) = $headerPair;
            $mappedHeaders[strtolower($name)] = $value;
        }

        return $mappedHeaders;
    }
}
