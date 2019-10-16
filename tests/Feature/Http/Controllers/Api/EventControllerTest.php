<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Support\Events\Contracts\EventRepository;
use App\User;
use Tests\TestCase;

class EventControllerTest extends TestCase
{

//    /** @test */
//    public function index_can_only_be_accessed_by_an_authenticated_user(){
//        $response = $this->json('get', '/api/events');
//        $response->assertUnauthorized();
//
//        $this->be(factory(User::class)->create(), 'api');
//        $this->instance(EventRepository::class, $this->prophesize(EventRepository::class)->reveal());
//        $response = $this->json('get', '/api/events');
//    }
//
//    /** @test */
//    public function index_returns_the_event_repository_result(){
//        $this->be(factory(User::class)->create(), 'api');
//        $eventRepository = $this->prophesize(EventRepository::class);
//        $eventRepository->all()->shouldBeCalled()->willReturn(['event1', 'event2']);
//        $this->instance(EventRepository::class, $eventRepository->reveal());
//
//        $response = $this->json('get', '/api/events');
//        $response->assertJson(['event1', 'event2']);
//    }

}
