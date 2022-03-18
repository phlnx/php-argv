<?php

namespace phlnx\PHP;

class ArgvParserTest extends \PHPUnit_Framework_TestCase
{

    public function testSingleArgument()
    {
        $argvParser = new ArgvParser();

        $string = '--ok';
        $result = $argvParser->parse($string);
        $this->assertEquals($result['switch']['ok'], true);
    }

    public function testParseConfigs()
    {
        $argvParser = new ArgvParser();

        $string = '-h=127.0.0.1 -u=user -p=passwd --debug --max-size=3 test';

        $result = $argvParser->parse($string);


        $this->assertEquals('127.0.0.1', $result['switch']['h']);
        $this->assertEquals('user', $result['switch']['u']);
        $this->assertEquals('passwd', $result['switch']['p']);
        $this->assertEquals(true, $result['switch']['debug']);
        $this->assertEquals('3', $result['switch']['max-size']);
        $this->assertEquals('test', $result['param'][0]);

        $commandArr = explode(' ', $string);

        $result = $argvParser->parse($commandArr);

        $this->assertEquals('127.0.0.1', $result['switch']['h']);
        $this->assertEquals('user', $result['switch']['u']);
        $this->assertEquals('passwd', $result['switch']['p']);
        $this->assertEquals(true, $result['switch']['debug']);
        $this->assertEquals('3', $result['switch']['max-size']);
        $this->assertEquals('test', $result['param'][0]);

        $option = '--foo=bar-baz';

        $result = $argvParser->parse($option);
        $this->assertEquals('bar-baz', $result['switch']['foo']);

        global $argv;
        $argv = array_merge(array('filename'), $commandArr);

        $result = $argvParser->parse();

        $this->assertEquals('127.0.0.1', $result['switch']['h']);
        $this->assertEquals('user', $result['switch']['u']);
        $this->assertEquals('passwd', $result['switch']['p']);
        $this->assertEquals(true, $result['switch']['debug']);
        $this->assertEquals('3', $result['switch']['max-size']);
        $this->assertEquals('test', $result['param'][0]);
        $this->assertEquals(1, count($result['param']));

    }

}
