<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AccountTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testApiList()
    {
        $data = factory(\App\Account::class, 20)->create();
        $response = $this->get('/api/accounts');
        $response->seeStatusCode(200)
            //->assertExactJson(['data'=>$data->toArray()]);
            ->assertJson((string)$data);
    }
    public function testApiView()
    {
        $data = factory(\App\Account::class)->create();
        $response = $this->json('GET', '/api/accounts/'.$data->id);

        $response->seeStatusCode(200)
            ->assertJson((string)$data);
    }
    public function testApiViewNotFound()
    {
        $response = $this->json('GET', '/api/accounts/1');
        $response->seeStatusCode(404);
    }
    public function testApiInsert()
    {
        $data = factory(\App\Account::class)->make();
        $response = $this->json('POST', 'api/accounts', $data->toArray());
        $data = (string)$data;
        $response->seeStatusCode(200)
            ->assertJson($data);
    }

    public function testApiUpdate()
    {
        $data = factory(\App\Account::class)->create();
        $toUpdate = ['title' => 'Conta do Erik'];

        $response = $this->json('PUT', '/api/accounts/' . $data->id, $toUpdate);
        $toUpdate=json_encode($toUpdate);
        $response->seeStatusCode(200)
            ->assertJson($toUpdate);
    }

    public function testApiDelete()
    {
        $data = factory(\App\Account::class)->create();
        $response = $this->json('DELETE', '/api/accounts/' . $data->id);
        $response->seeStatusCode(200)
            ->assertJson((string)$data);
    }
   /* public function testApiUploadOnInsert()
    {
        $data = factory(\App\Account::class)->make();
        $data = $data->toArray();
        Storage::fake('public');
        $data['bank_image'] = UploadedFile::fake()->image('itau.jpg');
        $response = $this->json('POST', 'api/accounts', $data);
        Storage::disk('public')->assertExists('images/itau.jpg');
    }*/


}
