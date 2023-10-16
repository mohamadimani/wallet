<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /**
     * test index.
     */
    public function testIndex(): void
    {
        $response = $this->get('api/v1/payments');
        $response->assertStatus(200);
    }

    /**
     * test index.
     */
    public function testShow(): void
    {
        $response = $this->get('api/v1/payments/1697486619SjMjM');
        $response->assertStatus(200);
    }

    /**
     * test index.
     */
    public function testReject(): void
    {
        $response = $this->patch('api/v1/payments/1697486619SjMjM/reject');
        $response->assertStatus(200);
    }

    /**
     * test index.
     */
    public function testVerify(): void
    {
        $response = $this->patch('api/v1/payments/16974868615EVTd/verify');
        $response->assertStatus(200);
    }



}
