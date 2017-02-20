<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Console\Command;
use Belt\Core\Commands\Behaviors\ProcessTrait;

class ProcessTraitTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\Behaviors\ProcessTrait::process
     */
    public function testHandle()
    {

        $cmd = new ProcessTraitTestStub();

        # process
        $result = $cmd->process('echo hello');
        $this->assertTrue(str_contains($result, 'hello'));

        # process (bad command)
        try {
            $cmd->process('foo');
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

    }

}


class ProcessTraitTestStub extends Command
{
    use ProcessTrait;

    protected $name = 'process-trait';
}