<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Alert;
use Illuminate\Database\Eloquent\Builder;

class AlertTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Alert::setIsActiveAttribute
     * @covers \Belt\Core\Alert::setNameAttribute
     * @covers \Belt\Core\Alert::scopeActive
     */
    public function test()
    {
        $alert = factory(Alert::class)->make();

        Alert::unguard();

        $alert->is_active = 1;
        $alert->name = ' TEST ';

        $attributes = $alert->getAttributes();

        # scopeActive
        $datetime = date('Y-m-d H:i:s', strtotime('now'));
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('alerts.is_active', true);
        $qbMock->shouldReceive('where')->twice()->with(
            m::on(function (\Closure $closure) use ($datetime) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('whereNull')->with('alerts.starts_at');
                $subQBMock->shouldReceive('whereNull')->with('alerts.ends_at');
                $subQBMock->shouldReceive('orWhere')->with('alerts.starts_at', '<=', $datetime);
                $subQBMock->shouldReceive('orWhere')->with('alerts.ends_at', '>=', $datetime);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $alert->scopeActive($qbMock, $datetime);

        # setters
        $this->assertEquals('TEST', $alert->__toString());
        $this->assertEquals(true, $attributes['is_active']);
        $this->assertEquals('TEST', $attributes['name']);
    }

}