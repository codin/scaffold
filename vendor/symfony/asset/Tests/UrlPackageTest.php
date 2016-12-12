<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Asset\Tests;

use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class UrlPackageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getConfigs
     */
    public function testGetUrl($baseUrls, $format, $path, $expected)
    {
        $package = new UrlPackage($baseUrls, new StaticVersionStrategy('v1', $format));
        $this->assertEquals($expected, $package->getUrl($path));
    }

    public function getConfigs()
    {
        return array(
            array('http://example.net', '', 'http://example.com/foo', 'http://example.com/foo'),
            array('http://example.net', '', 'https://example.com/foo', 'https://example.com/foo'),
            array('http://example.net', '', '//example.com/foo', '//example.com/foo'),

            array('http://example.com', '', '/foo', 'http://example.com/foo?v1'),
            array('http://example.com', '', 'foo', 'http://example.com/foo?v1'),
            array('http://example.com/', '', 'foo', 'http://example.com/foo?v1'),
            array('http://example.com/foo', '', 'foo', 'http://example.com/foo/foo?v1'),
            array('http://example.com/foo/', '', 'foo', 'http://example.com/foo/foo?v1'),

            array(array('http://example.com'), '', '/foo', 'http://example.com/foo?v1'),
            array(array('http://example.com', 'http://example.net'), '', '/foo', 'http://example.com/foo?v1'),
            array(array('http://example.com', 'http://example.net'), '', '/fooa', 'http://example.net/fooa?v1'),

            array('http://example.com', 'version-%2$s/%1$s', '/foo', 'http://example.com/version-v1/foo'),
            array('http://example.com', 'version-%2$s/%1$s', 'foo', 'http://example.com/version-v1/foo'),
            array('http://example.com', 'version-%2$s/%1$s', 'foo/', 'http://example.com/version-v1/foo/'),
            array('http://example.com', 'version-%2$s/%1$s', '/foo/', 'http://example.com/version-v1/foo/'),
        );
    }

    /**
     * @dataProvider getContextConfigs
     */
    public function testGetUrlWithContext($secure, $baseUrls, $format, $path, $expected)
    {
        $package = new UrlPackage($baseUrls, new StaticVersionStrategy('v1', $format), $this->getContext($secure));

        $this->assertEquals($expected, $package->getUrl($path));
    }

    public function getContextConfigs()
    {
        return array(
            array(false, 'http://example.com', '', 'foo', 'http://example.com/foo?v1'),
            array(false, array('http://example.com'), '', 'foo', 'http://example.com/foo?v1'),
            array(false, array('http://example.com', 'https://example.com'), '', 'foo', 'http://example.com/foo?v1'),
            array(false, array('http://example.com', 'https://example.com'), '', 'fooa', 'https://example.com/fooa?v1'),
            array(false, array('http://example.com/bar'), '', 'foo', 'http://example.com/bar/foo?v1'),
            array(false, array('http://example.com/bar/'), '', 'foo', 'http://example.com/bar/foo?v1'),
            array(false, array('//example.com/bar/'), '', 'foo', '//example.com/bar/foo?v1'),

            array(true, array('http://example.com'), '', 'foo', 'http://example.com/foo?v1'),
            array(true, array('http://example.com', 'https://example.com'), '', 'foo', 'https://example.com/foo?v1'),
        );
    }

    /**
     * @expectedException \Symfony\Component\Asset\Exception\LogicException
     */
    public function testNoBaseUrls()
    {
        new UrlPackage(array(), new EmptyVersionStrategy());
    }

    /**
     * @expectedException \Symfony\Component\Asset\Exception\InvalidArgumentException
     */
    public function testWrongBaseUrl()
    {
        new UrlPackage(array('not-a-url'), new EmptyVersionStrategy());
    }

    private function getContext($secure)
    {
        $context = $this->getMock('Symfony\Component\Asset\Context\ContextInterface');
        $context->expects($this->any())->method('isSecure')->will($this->returnValue($secure));

        return $context;
    }
}
