<?php

use Mockery as m;
use Belt\Core\Behaviors\Teamable;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamableTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Teamable::team
     */
    public function test()
    {
        $teamable = new TeamableStub();

        # team
        $this->assertInstanceOf(BelongsTo::class, $teamable->team());
    }

}

class TeamableStub extends Testing\BaseModelStub
{
    use Teamable;

    public function load($relations)
    {

    }

    public function getMorphClass()
    {
        return 'teamable-stubs';
    }

}