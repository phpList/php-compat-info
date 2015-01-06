<?php
/**
 * Unit tests for PHP_CompatInfo package, issues reported
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    PHP_CompatInfo
 * @subpackage Tests
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @author     Remi Collet <Remi@FamilleCollet.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    GIT: $Id$
 * @link       http://php5.laurent-laville.org/compatinfo/
 * @since      Class available since Release 4.0.0-alpha2+1
 */

namespace Bartlett\Tests\CompatInfo\Reference;

use Bartlett\Reflect\Client;

/**
 * Tests for PHP_CompatInfo, retrieving reference elements,
 * and versioning information.
 *
 * @category   PHP
 * @package    PHP_CompatInfo
 * @subpackage Tests
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @author     Remi Collet <Remi@FamilleCollet.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://php5.laurent-laville.org/compatinfo/
 */
class PhpFeaturesIssueTest extends \PHPUnit_Framework_TestCase
{
    const GH140 = 'gh140.php';
    const GH141 = 'gh141.php';
    const GH142 = 'gh142.php';
    const GH143 = 'gh143.php';
    const GH148 = 'gh148.php';
    const GH154 = 'gh154.php';

    protected static $fixtures;
    protected static $api;

    /**
     * Sets up the shared fixture.
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        self::$fixtures = __DIR__ . DIRECTORY_SEPARATOR
            . 'fixtures' . DIRECTORY_SEPARATOR;

        $client = new Client();

        // request for a Bartlett\Reflect\Api\Analyser
        self::$api = $client->api('analyser');
    }

    /**
     * Regression test for feature GH#140
     *
     * @link https://github.com/llaville/php-compat-info/issues/140
     *       Constant scalar expressions are 5.6+
     * @link http://php.net/manual/en/migration56.new-features.php#migration56.new-features.const-scalar-exprs
     * @group features
     * @group regression
     * @return void
     */
    public function testFeatureGH140()
    {
        $dataSource = self::$fixtures . self::GH140;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.6.0',
                'php.max'      => '',
            ),
            $versions
        );
    }

    /**
     * Regression test for feature GH#141
     *
     * @link https://github.com/llaville/php-compat-info/issues/141
     *       Variadic functions are 5.6+
     * @link http://php.net/manual/en/migration56.new-features.php#migration56.new-features.variadics
     * @group features
     * @group regression
     * @return void
     */
    public function testFeatureGH141()
    {
        $dataSource = self::$fixtures . self::GH141;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.6.0',
                'php.max'      => '',
            ),
            $versions
        );
    }

    /**
     * Regression test for feature GH#142
     *
     * @link https://github.com/llaville/php-compat-info/issues/142
     *       Exponentiation is 5.6+
     * @link http://php.net/manual/en/migration56.new-features.php#migration56.new-features.exponentiation
     * @group features
     * @return void
     */
    public function testFeatureGH142()
    {
        $dataSource = self::$fixtures . self::GH142;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.6.0',
                'php.max'      => '',
            ),
            $versions
        );
    }

    /**
     * Regression test for feature GH#143
     *
     * @link https://github.com/llaville/php-compat-info/issues/143
     *       use const, use function are 5.6+
     * @link http://php.net/manual/en/migration56.new-features.php#migration56.new-features.use
     * @group features
     * @return void
     */
    public function testFeatureGH143()
    {
        $dataSource = self::$fixtures . self::GH143;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.6.0',
                'php.max'      => '',
            ),
            $versions
        );
    }

    /**
     * Regression test for feature GH#148
     *
     * @link https://github.com/llaville/php-compat-info/issues/148
     *       Array short syntax and array dereferencing not detected
     * @link http://php.net/manual/en/migration54.new-features.php
     * @group features
     * @group regression
     * @return void
     */
    public function testBugGH148()
    {
        $dataSource = self::$fixtures . self::GH148;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.4.0',
                'php.max'      => '',
            ),
            $versions
        );
    }

    /**
     * Regression test for feature GH#154
     *
     * @link https://github.com/llaville/php-compat-info/issues/154
     *       Class member access on instantiation
     * @link http://php.net/manual/en/migration54.new-features.php
     * @group features
     * @group regression
     * @return void
     */
    public function testBugGH154()
    {
        $dataSource = self::$fixtures . self::GH154;
        $analysers  = array('compatibility');
        $metrics    = self::$api->run($dataSource, $analysers);
        $versions   = $metrics['CompatibilityAnalyser']['versions'];

        $this->assertEquals(
            array(
                'php.min'      => '5.4.0',
                'php.max'      => '',
            ),
            $versions
        );
    }
}
