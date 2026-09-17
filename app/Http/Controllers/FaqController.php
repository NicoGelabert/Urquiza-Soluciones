<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\PaginaContenido;
use App\Models\PaginaLegal;
use App\Models\Solicitud;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function index()
    {
        return Inertia::render('Faqs/Index');
    }

    public function create()
    {
        return Inertia::render('Faqs/Create');
    }

    public function edit(Faq $faq)
    {
        return Inertia::render('Faqs/Edit', ['id' => $faq->id]);
    }
}
