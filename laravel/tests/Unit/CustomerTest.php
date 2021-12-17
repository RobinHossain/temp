<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_form_page_can_be_rendered() {

        $response = $this->get('/customers/form');

        $response->assertStatus(200);

    }

    public function test_new_customer_info_can_be_store() {
        $response = $this->post('/customers/form', [
            'name' => 'John Due2',
            'phone' => '01234567890',
            'email' => 'juejohn13@mail.com',
            'budget' => 290348,
            'message' => 'Test Message 123',
        ]);
        $response->assertRedirect('/customers/form');
    }

    public function test_can_be_able_to_create_wp_profile(){
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $customer = Customer::factory()->create();

        $response = $this->post('/customers/createWpAccount', [
            'id' => $customer->id
        ]);
        $response->assertJson(['account_created' => true]);
    }
}
