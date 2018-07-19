<?php

use Mockery as m;

use Belt\Core\Services\ContactService;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PostContact;
use Belt\Core\Mail\ContactSubmitted;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\PendingMail;

class ContactServiceTest extends Testing\BeltTestCase
{
    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\ContactService::__construct
     * @covers \Belt\Core\Services\ContactService::configPath
     * @covers \Belt\Core\Services\ContactService::configDefaults
     * @covers \Belt\Core\Services\ContactService::errors
     * @covers \Belt\Core\Services\ContactService::mailable
     * @covers \Belt\Core\Services\ContactService::mail
     * @covers \Belt\Core\Services\ContactService::get
     * @covers \Belt\Core\Services\ContactService::setRequest
     * @covers \Belt\Core\Services\ContactService::getRequest
     * @covers \Belt\Core\Services\ContactService::setTemplate
     * @covers \Belt\Core\Services\ContactService::getTemplate
     * @covers \Belt\Core\Services\ContactService::queue
     * @covers \Belt\Core\Services\ContactService::users
     * @covers \Belt\Core\Services\ContactService::validates
     */
    public function test()
    {
        app()['config']->set('belt.core.contact.default', [
            'foo' => 'bar',
            'mailable_class' => ContactSubmitted::class,
            'request_class' => PostContact::class,
            'from' => [
                'email' => 'user@test.com',
            ],
            'cc' => 'user@test.com',
            'bcc' => 'user@test.com',
        ]);

        # __construct
        # getRequest
        $service = new ContactService();
        $this->assertInstanceOf(Request::class, $service->getRequest());

        # configPath
        $this->assertEquals('belt.core.contact.default', $service->configPath());

        # configDefaults
        $this->assertNotEmpty($service->configDefaults());

        # errors
        $service = new ContactService();
        $this->assertEmpty($service->errors());
        $service->setRequest(new PostContact())->validates();
        $this->assertNotEmpty($service->errors());

        # get
        $this->assertEquals('bar', $service->get('foo', 'default'));
        $service->setRequest(new PostContact(['foo' => 'new-bar']));
        $this->assertEquals('new-bar', $service->get('foo', 'default'));
        $this->assertEquals('default', $service->get('new-foo', 'default'));

        # request
        $service->setRequest(new PostContact(['subtype' => 'test']));
        $this->assertInstanceOf(Request::class, $service->getRequest());

        # template
        $service->setRequest(new PostContact(['subtype' => 'foo']));
        $this->assertEquals('foo', $service->getTemplate());

        # queue


        # users
        $this->assertEquals(['user1@test.com', 'user2@test.com'], $service->users('user1@test.com,user2@test.com'));
        $this->assertEquals([['email' => 'user1@test.com']], $service->users(['email' => 'user1@test.com']));
        $this->assertEquals([
            ['email' => 'user1@test.com'],
            ['email' => 'user2@test.com'],
        ], $service->users([
            ['email' => 'user1@test.com'],
            ['email' => 'user2@test.com'],
        ]));
        try {
            $service->users([['foo' => 'user1@test.com']]);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # validates
        $service = new ContactService();
        $service->setRequest(new PostContact());
        $this->assertFalse($service->validates());
        $service = new ContactService();
        $service->setRequest(new PostContact([
            'name' => 'test',
            'email' => 'test@test.com',
            'comments' => 'test',
        ]));
        $this->assertTrue($service->validates());

        # mailable, mail, queue
        $service = new ContactService();
        $service->setRequest(new PostContact(['subject' => 'test']));
        $mailable = $service->mailable();
        $mail = $service->mail();
        $this->assertInstanceOf(Mailable::class, $mailable);
        $this->assertInstanceOf(PendingMail::class, $mail);

        # queue
        $mail = m::mock(PendingMail::class);
        $mail->shouldReceive('queue')->once()->with($mailable)->andReturnSelf();
        $service->queue($mailable, $mail);
    }

}