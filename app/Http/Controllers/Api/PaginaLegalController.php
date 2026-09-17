<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginaLegalRequest;
use App\Http\Resources\PaginaLegalResource;
use App\Models\PaginaLegal;

class PaginaLegalController extends Controller
{
    public function index()
    {
        return PaginaLegalResource::collection(
            PaginaLegal::query()->orderBy('slug')->get(),
        );
    }

    public function show(PaginaLegal $legal)
    {
        return new PaginaLegalResource($legal);
    }

    public function update(PaginaLegalRequest $request, PaginaLegal $legal)
    {
        $legal->update($request->validated());

        return new PaginaLegalResource($legal);
    }
}
