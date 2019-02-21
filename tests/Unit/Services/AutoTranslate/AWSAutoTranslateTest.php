<?php namespace Tests\Belt\Core\Unit\Services;

use Aws\Result;
use Aws\Translate\TranslateClient;
use Belt\Core\Services\AutoTranslate\AWSAutoTranslate;
use Belt\Core\Tests;
use Mockery as m;

class AWSAutoTranslateTest extends Tests\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\AutoTranslate\AWSAutoTranslate::client
     * @covers \Belt\Core\Services\AutoTranslate\AWSAutoTranslate::translate
     * @covers \Belt\Core\Services\AutoTranslate\AWSAutoTranslate::__translate
     */
    public function test()
    {
        $this->enableI18n();

        # client
        $service = new AWSAutoTranslate();
        $this->assertInstanceOf(TranslateClient::class, $service->client());

        # translate;
        $faker = \Faker\Factory::create();

        $text = $faker->text(6000);
        $target_locale = 'es_ES';
        $source_local = 'en_US';

        $awsResult = m::mock(Result::class);
        $awsResult->shouldReceive('get')->once()->with('TranslatedText')->andReturn('foo1 translated.');
        $awsResult->shouldReceive('get')->once()->with('TranslatedText')->andReturn('foo2 translated.');

        $client = m::mock(TranslateClient::class);
        $client->shouldReceive('translateText')->once()->with(
            [
                'SourceLanguageCode' => 'en',
                'TargetLanguageCode' => 'es',
                'Text' => 'foo1',
            ]
        )->andReturn($awsResult);
        $client->shouldReceive('translateText')->once()->with(
            [
                'SourceLanguageCode' => 'en',
                'TargetLanguageCode' => 'es',
                'Text' => 'foo2',
            ]
        )->andReturn($awsResult);

        $service = m::mock(AWSAutoTranslate::class . '[split]');
        $service->client = $client;
        $service->shouldReceive('split')->once()->with($text, 3000)->andReturn(['foo1', 'foo2']);

        $translatedText = $service->translate($text, $target_locale, $source_local);

        $this->assertEquals('foo1 translated. foo2 translated.', $translatedText);
    }

}