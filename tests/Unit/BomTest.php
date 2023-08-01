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
            'uom' => 'kg',
            'is_active' => true,
            'quantity' => 10,
            'is_default' => true,
            'allow_alternative' => false,
            'rate_set' => true,
            'project' => 'Project A',
            'items_count' => 1,
            'rawMaterials' => [
                [
                    'id' => 1,
                    'qty' => 5,
                    'price' => 10.99,
                ],
                [
                    'id' => 2,
                    'qty' => 8,
                    'price' => 5.75,
                ],
            ],
        ];

        // Enable exception handling to see detailed error messages
        $this->withoutExceptionHandling();

        try {

            $response = $this->call('POST', 'boms', $data);
            $response->assertStatus(201);
            $response->assertJson(['status' => true, 'message' => "Ok"]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        // Assert that the database was updated correctly
        $this->assertDatabaseHas('boms', [
            'product_id' => $data['product_id'],
            'uom' => $data['uom'],
            'is_active' => $data['is_active'],
            'quantity' => $data['quantity'],
            'is_default' => $data['is_default'],
            'allow_alternative' => $data['allow_alternative'],
            'rate_set' => $data['rate_set'],
            'project' => $data['project'],
        ]);
        $bom = Bom::where('product_id', $data['product_id'])->first();

        foreach ($data['rawMaterials'] as $material) {
            $this->assertDatabaseHas('bom_raw_materials', [
                'bom_id' => $bom->id,
                'raw_material_id' => $material['id'],
                'quantity' => $material['qty'],
                'unit_price' => $material['price'],
                'amount' => $material['qty'] * $material['price'],
                'user_id' => auth()->id(),
            ]);
        }
    }
}
