<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\CarCatalog;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    public function index()
    {
        $this->authorize('cars-manage');
        $cars = CarCatalog::all();

        return response()->json($cars);
    }

    public function show($id)
    {
        $this->authorize('cars-manage');
        $car = CarCatalog::findOrFail($id);

        return response()->json($car);
    }

    public function store(Request $request)
    {
        $this->authorize('cars-manage');
        $request->validate([
            'merk' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'plat_number' => ['required', 'string', 'max:255', Rule::unique('car_catalogs')],
            'price' => ['required', 'numeric'],
        ]);

        $car = CarCatalog::create($request->all());

        return response()->json($car, 201);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('cars-manage');
        $request->validate([
            'merk' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'plat_number' => ['required', 'string', 'max:255', Rule::unique('car_catalogs')->ignore($id)],
            'price' => ['required', 'numeric'],
        ]);

        $car = CarCatalog::findOrFail($id);
        $car->update($request->all());

        return response()->json($car, 200);
    }

    public function destroy($id)
    {
        $this->authorize('cars-manage');
        $car = CarCatalog::findOrFail($id);
        $car->delete();

        return response()->json(['message' => 'Car deleted successfully'], 200);
    }
}
