<?php

namespace Kagency\HttpReplay\Reader;

use Kagency\HttpReplay\Interaction;

class MitmDumpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get interactions
     *
     * @return array
     */
    public function getInteractions()
    {
        return array(
            array(
                __DIR__ . '/_fixtures/replication.tns',
                array(
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                    new Interaction('request', 'response'),
                ),
            ),
        );
    }

    /**
     * @dataProvider getInteractions
     */
    public function testReadInteractions($file, $expectation)
    {
        $messageHandler = $this->getMock('\\Kagency\\HttpReplay\\MessageHandler');
        $messageHandler
            ->expects($this->any())
            ->method('convertFromRequest')
            ->will($this->returnValue('request'));
        $messageHandler
            ->expects($this->any())
            ->method('convertFromResponse')
            ->will($this->returnValue('response'));

        $reader = new MitmDump($messageHandler);
        $interactions = $reader->readInteractions($file);

        $this->assertEquals(
            $expectation,
            $interactions
        );
    }
}
