<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqListResource;
use App\Http\Resources\FaqResource;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'orden');
        $sortDirection = request('sort_direction', 'asc');
        $servicioId = request('servicio_id');

        $query = Faq::query()
            ->with('servicio')
            ->when($servicioId, fn ($q) => $q->where('servicio_id', $servicioId))
            ->where(function ($q) use ($search) {
                $q->where('pregunta->es', 'like', "%{$search}%")
                    ->orWhere('pregunta->en', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return FaqListResource::collection($query);
    }

    public function store(FaqRequest $request)
    {
        $faq = Faq::query()->create($request->validated());

        return new FaqResource($faq->load('servicio'));
    }

    public function show(Faq $faq)
    {
        return new FaqResource($faq->load('servicio'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return new FaqResource($faq->load('servicio'));
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->noContent();
    }
}
