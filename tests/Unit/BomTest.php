<?php

namespace Tests\Unit;

use App\Models\Bom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Request;

class BomTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_save_bom(): void
    {
        // Create a user or use an existing one
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        // Prepare mock data for the request
        $data = [
            'product_id' => 1,
            'bom' => [
                'uom' => 'kg',
                'is_active' => true,
                'quantity' => 10,
                'is_default' => true,
                'allow_alternative' => false,
                'rate_set' => true,
                'project' => 'Project A',
                'items_count' => 1
            ],
            'rawMaterials' => [
                [
                    'id' => 1,
                    'qty' => 5,
                    'price' => 10.99,
                    'amount' => 54.95,
                ],
                [
                    'id' => 2,
                    'qty' => 8,
                    'price' => 5.75,
                    'amount' => 46.00,
                ],
            ],
        ];

        // Create a mock request
        $request = new Request([], $data);

        // Enable exception handling to see detailed error messages
        $this->withoutExceptionHandling();

        try {

            // Run the function and assert the response
            $response = $this->call('POST', 'bom', $data);

            // Assert that the response status code is 201 (Created)
            $response->assertStatus(201);
            // Assert that the response contains the correct JSON data
            $response->assertJson(['status' => true, 'message' => "Ok"]);
        } catch (\Exception $e) {
            dd($e->getMessage()); // Debug the exception message
            throw $e; // Re-throw the exception to fail the test
        }
        // Assert that the database was updated correctly
        $this->assertDatabaseHas('boms', [
            'product_id' => $data['product_id'],
            'uom' => $data['bom']['uom'],
            'is_active' => $data['bom']['is_active'],
            'quantity' => $data['bom']['quantity'],
            'is_default' => $data['bom']['is_default'],
            'allow_alternative' => $data['bom']['allow_alternative'],
            'rate_set' => $data['bom']['rate_set'],
            'project' => $data['bom']['project'],
        ]);
        $bom = Bom::where('product_id', $data['product_id'])->first();

        foreach ($data['rawMaterials'] as $material) {
            $this->assertDatabaseHas('bom_raw_materials', [
                'bom_id' => $bom->id,
                'raw_material_id' => $material['id'],
                'quantity' => $material['qty'],
                'unit_price' => $material['price'],
                'amount' => $material['amount'],
                'user_id' => auth()->id(),
            ]);
        }
    }
}
