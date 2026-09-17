<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('slug_en')->unique();
            $table->string('icono')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->string('imagen_cabecera')->nullable();
            $table->json('titulo');
            $table->json('hero_subtitulo')->nullable();
            $table->json('descripcion_corta');
            $table->json('descripcion_larga');
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('servicio_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained()->cascadeOnDelete();
            $table->string('ruta');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('servicio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained()->cascadeOnDelete();
            $table->json('titulo');
            $table->json('descripcion')->nullable();
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->nullable()->constrained()->nullOnDelete();
            $table->json('pregunta');
            $table->json('respuesta');
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('pagina_contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->json('titulo')->nullable();
            $table->json('contenido')->nullable();
            $table->json('datos_extra')->nullable();
            $table->timestamps();
        });

        Schema::create('pagina_legals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('titulo');
            $table->json('contenido');
            $table->timestamps();
        });

        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('estado')->default('pendiente');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->text('mensaje');
            $table->foreignId('servicio_id')->nullable()->constrained()->nullOnDelete();
            $table->string('zona')->nullable();
            $table->text('notas_admin')->nullable();
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->text('valor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
        Schema::dropIfExists('solicitudes');
        Schema::dropIfExists('pagina_legals');
        Schema::dropIfExists('pagina_contenidos');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('servicio_items');
        Schema::dropIfExists('servicio_imagenes');
        Schema::dropIfExists('servicios');
    }
};
