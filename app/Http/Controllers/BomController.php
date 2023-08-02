<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\BomRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function saveBom(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'uom' => 'nullable',
            'is_active' => 'sometimes',
            'quantity' => 'required',
            'is_default' => 'sometimes',
            'allow_alternative' => 'sometimes',
            'rate_set' => 'sometimes',
            'project' => 'sometimes'
        ]);

        try {
            DB::beginTransaction();

            $bom = Bom::create([
                'product_id' => $request->product_id,
                'uom' => $request->uom,
                'is_active' => $request->is_active ?? 0,
                'quantity' => $request->quantity,
                'is_default' => $request->is_default ?? 0,
                'allow_alternative' => $request->allow_alternative ?? 0,
                'rate_set' => $request->rate_set ?? 0,
                'project' => $request->project ?? null,
                'items_count' => count($request['rawMaterials'])
            ]);

            $this->saveBomMaterial($bom, $request['rawMaterials']);

            DB::commit();

        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollback();
            throw $e;
        }

        return response()->json(['status' => true, 'message' => "Ok"], 201);
    }

    private function saveBomMaterial($bom, mixed $rawMaterials)
    {
        $materials = [];
        foreach ($rawMaterials as $material) {
            $materials[] = [
                'bom_id' => $bom->id,
                'raw_material_id' => $material['id'],
                'quantity' => $material['qty'],
                'unit_price' => $material['price'],
                'amount' => $material['qty'] * $material['price'],
                'user_id' => auth()->id()
            ];
        }

        BomRawMaterial::insert($materials);

        return true;

    }

    public function listBoms()
    {
        $boms = Bom::with('product')->get();

        return view('admin.boms.index', compact('boms'));
    }
}
