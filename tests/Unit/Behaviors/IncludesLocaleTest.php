<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\IncludesLocale;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Model;

class IncludesLocaleTest extends \Tests\Belt\Core\BeltTestCase
{
    /**
     * @covers \Belt\Core\Behaviors\IncludesLocale::bootIncludesLocale
     * @covers \Belt\Core\Behaviors\IncludesLocale::setLocaleAttribute
     * @covers \Belt\Core\Behaviors\IncludesLocale::getLocaleAttribute
     */
    public function test()
    {
        $this->enableI18n();

        # bootIncludesLocale
        IncludesLocaleTestStub::bootIncludesLocale();

        $stub = new IncludesLocaleTestStub();

        # bootIncludesLocale
        $stub->bootIncludesLocale();

        # locale
        $stub->setLocaleAttribute(' Test ');
        $this->assertEquals('en_US', $stub->locale);
        $stub->setLocaleAttribute('es_ES');
        $this->assertEquals('es_ES', $stub->locale);
    }

}

class IncludesLocaleTestStub extends Model
{
    use IncludesLocale;

    public function getMorphClass()
    {
        return 'pages';
    }
}