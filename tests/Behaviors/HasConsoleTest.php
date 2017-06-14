<?php

use Mockery as m;
use Belt\Core\Behaviors\HasConsole;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class HasConsoleTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Belt\Core\Behaviors\HasConsole::info
     * covers \Belt\Core\Behaviors\HasConsole::warn
     */
    public function test()
    {
        $stub = new HasConsoleTestStub();
        $this->assertNull($stub->info('foo'));
        $this->assertNull($stub->warn('foo'));

        $console = m::mock(Command::class);
        $console->shouldReceive('info')->with('foo', null)->andReturnSelf();
        $console->shouldReceive('warn')->with('foo', null)->andReturnSelf();
        $stub->console = $console;
        $stub->info('foo');
        $stub->warn('foo');
    }

}

class HasConsoleTestStub extends Model
{
    use HasConsole;

}