<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicioRequest;
use App\Http\Resources\ServicioListResource;
use App\Http\Resources\ServicioResource;
use App\Models\Servicio;
use App\Models\ServicioItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServicioController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'orden');
        $sortDirection = request('sort_direction', 'asc');

        $query = Servicio::query()
            ->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                    ->orWhere('titulo->es', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ServicioListResource::collection($query);
    }

    public function store(ServicioRequest $request)
    {
        $data = collect($request->validated())->except('items', 'imagen_cabecera')->all();
        $items = $request->validated('items') ?? [];

        if ($request->hasFile('imagen_cabecera')) {
            $data['imagen_cabecera'] = $this->saveImage($request->file('imagen_cabecera'));
        }

        $servicio = Servicio::query()->create($data);
        $this->syncItems($servicio, $items);

        return new ServicioResource($servicio->load('items'));
    }

    public function show(Servicio $servicio)
    {
        return new ServicioResource($servicio->load('items'));
    }

    public function update(ServicioRequest $request, Servicio $servicio)
    {
        $data = collect($request->validated())->except('items', 'imagen_cabecera')->all();
        $items = $request->validated('items') ?? [];

        if ($request->hasFile('imagen_cabecera')) {
            if ($servicio->imagen_cabecera) {
                Storage::disk('public')->delete($servicio->imagen_cabecera);
            }
            $data['imagen_cabecera'] = $this->saveImage($request->file('imagen_cabecera'));
        }

        $servicio->update($data);
        $this->syncItems($servicio, $items);

        return new ServicioResource($servicio->load('items'));
    }

    public function destroy(Servicio $servicio)
    {
        if ($servicio->imagen_cabecera) {
            Storage::disk('public')->delete($servicio->imagen_cabecera);
        }

        $servicio->delete();

        return response()->noContent();
    }

    private function saveImage(UploadedFile $file): string
    {
        $path = 'servicios/'.Str::random(10);
        Storage::disk('public')->makeDirectory($path);
        $filename = $file->getClientOriginalName();
        Storage::disk('public')->putFileAs($path, $file, $filename);

        return $path.'/'.$filename;
    }

    private function syncItems(Servicio $servicio, array $items): void
    {
        $servicio->items()->delete();

        foreach ($items as $index => $item) {
            ServicioItem::query()->create([
                'servicio_id' => $servicio->id,
                'titulo' => $item['titulo'],
                'descripcion' => $item['descripcion'] ?? null,
                'orden' => $item['orden'] ?? ($index + 1),
            ]);
        }
    }
}
