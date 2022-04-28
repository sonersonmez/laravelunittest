<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_get_request()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/user');
        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_new_user()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/user/new', [
            'name' => 'Soner Sönmez',
            'email' => 'soonersonmez@outlook.com',
            'password' => 'soner123'
        ]);
        $response->assertOk();
        $this->assertCount(1, User::all());

       
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_new_user_name_require()
    {
      

        $response = $this->post('/user/new', [
            'name' => '',
            'email' => 'soonersonmez@outlook.com',
            'password' => 'soner123'
        ]);
        
        $response->assertSessionHasErrors('name');

       
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_new_user_email_require()
    {
        

        $response = $this->post('/user/new', [
            'name' => 'Soner',
            'email' => '',
            'password' => 'soner123'
        ]);
        
        $response->assertSessionHasErrors('email');

       
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_new_user_password_require()
    {
        

        $response = $this->post('/user/new', [
            'name' => 'Soner',
            'email' => 'soonersonmez@outlook.com',
            'password' => ''
        ]);
        
        $response->assertSessionHasErrors('password');

       
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_be_updated()
    {
        $this->post('/user/new', [
            'name' => 'Emre',
            'email' => 'emre@gmail.com',
            'password' => 'emre123'
        ]);

        $user = User::first();

        $response = $this->patch('/user/'.$user->id, [
            'name' => 'Emre Yıldırım',
            'email' => 'emre@yahoo.com',
            'password' => '123emre123'
        ]);

        $this->assertEquals('Emre Yıldırım', User::first()->name);
        $this->assertEquals('emre@yahoo.com', User::first()->email);
        $this->assertEquals('123emre123', User::first()->password);

       
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/user/new', [
            'name' => 'Burak Demirel',
            'email' => 'burakdemirel@gmail.com',
            'password' => 'drillcocuk'
        ]);

        $user = User::first();
        $this->assertCount(3, User::all());

        $this->delete('/user/'. $user->id);
        $this->assertCount(2, User::all());

       
    }

}
