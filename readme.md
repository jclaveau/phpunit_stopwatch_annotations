## PHPUnit stopwatch annotations

**PHPUnit stopwatch annotations** is a PHPUnit test case with support for execution time and memory usage assertion in annotations.
It uses [symfony/Stopwatch](https://github.com/symfony/Stopwatch) component for tracking time and memory usage of tests.

## Installation

Via [Composer](https://getcomposer.org/)

```bash 
	composer require --dev usernam3/phpunit_stopwatch_annotations
```

## Usage

To add support of ```@executionTime``` and ```@memoryUsage``` annotations you need to extend your test case class from ```\StopwatchAnnotations\TestCase```.

```@executionTime``` value is measured in milliseconds ```@memoryUsage``` in bytes.

Example of test case:

```php
class ExampleTest extends \StopwatchAnnotations\TestCase {
    /**
     * @test
     * @executionTime 1999
     */
    public function executionTimeFailed()
    {
        sleep(2);
    }
    
    /**
    * @test
    * @memoryUsage 2000000
    */
    public function memoryUsageFailed()
    {
    
    }
}
```