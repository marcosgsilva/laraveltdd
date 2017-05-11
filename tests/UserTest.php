<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;


    public function testAuthentication(){
        $user= factory(\App\User::class)->create();
        $response=$this->actingAs($user)
        ->get('/home');



        $response->seeStatusCode(200);
    }

    public function test_create_user()
    {
        \App\User::create([
            "name" => "Admin User",
            "email" => "marcos@admin.com",
            "password" => bcrypt(123456)
        ]);

        $this->seeInDatabase("users", ["name" => "Admin User"]);

    }
}
