<?php

namespace StopwatchAnnotations;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Class TestCase
 * @package StopwatchAnnotations
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    const MEMORY_WATCHER_ANNOTATION = 'memoryUsage';

    const TIME_WATCHER_ANNOTATION = 'executionTime';

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * @param Stopwatch $stopwatch
     * @return $this
     */
    public function setStopwatch($stopwatch)
    {
        $this->stopwatch = $stopwatch;
        return $this;
    }

    /**
     * @return void
     */
    protected function initStopWatch()
    {
        if (is_null($this->stopwatch)) {
            $this->stopwatch = new Stopwatch();
        }
    }

    /**
     * @return void
     */
    protected function checkAnnotationRequirements()
    {
        $annotations = $this->getAnnotations()['method'];
        $event = $this->stopwatch->stop($this->getName());

        $maxTime = (isset($annotations[self::TIME_WATCHER_ANNOTATION])) ?
            ($annotations[self::TIME_WATCHER_ANNOTATION][0]) :
            (null);
        $maxMemory = (isset($annotations[self::MEMORY_WATCHER_ANNOTATION])) ?
            ($annotations[self::MEMORY_WATCHER_ANNOTATION][0]) :
            (null);

        if (!is_null($maxTime)) {
            $this->assertLessThanOrEqual(
                (int)$maxTime,
                $event->getDuration(),
                'execution took longer than expected'
            );
        }

        if (!is_null($maxMemory)) {
            $this->assertLessThanOrEqual(
                (int)$maxMemory,
                $event->getMemory(),
                'execution took more memory than expected'
            );
        }
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->initStopWatch();

        $this->stopwatch->start($this->getName());

        parent::setUp();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->checkAnnotationRequirements();

        parent::tearDown();
    }
}
