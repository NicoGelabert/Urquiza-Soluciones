<?php

namespace App\Http\Controllers;

use App\Models\PaginaLegal;
use Inertia\Inertia;

class PaginaLegalController extends Controller
{
    public function index()
    {
        return Inertia::render('Legal/Index');
    }

    public function edit(PaginaLegal $legal)
    {
        return Inertia::render('Legal/Edit', ['id' => $legal->id]);
    }
}
