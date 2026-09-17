<?php

namespace Database\Seeders;

use App\Models\Servicio;
use App\Models\ServicioItem;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            [
                'slug' => 'aires-acondicionados',
                'slug_en' => 'air-conditioning',
                'icono' => 'snowflake',
                'orden' => 1,
                'titulo' => ['es' => 'Aires Acondicionados', 'en' => 'Air Conditioning'],
                'hero_subtitulo' => ['es' => 'Instalación y Mantenimiento', 'en' => 'Installation and Maintenance'],
                'descripcion_corta' => [
                    'es' => 'Mantenga su hogar siempre fresco con nuestros servicios de instalación, reparación y carga de gas para aires acondicionados. ¡Calidad y eficiencia garantizadas al mejor precio!',
                    'en' => 'Keep your home cool with our air conditioning installation, repair and refrigerant recharge services. Quality and efficiency guaranteed at the best price!',
                ],
                'descripcion_larga' => [
                    'es' => 'Instalación de aires acondicionados de todas las marcas y modelos. Ofrecemos mantenimiento preventivo, reparación con garantía y servicio de emergencia para su tranquilidad.',
                    'en' => 'Installation of air conditioning units of all brands and models. We offer preventive maintenance, guaranteed repairs and emergency service for your peace of mind.',
                ],
                'items' => [
                    ['es' => 'Instalación de aires acondicionados de todas las marcas y modelos.', 'en' => 'Installation of air conditioning units of all brands and models.'],
                    ['es' => 'Mantenimiento preventivo para prolongar la vida útil de su equipo.', 'en' => 'Preventive maintenance to extend the life of your equipment.'],
                    ['es' => 'Reparación de unidades con garantía de piezas y mano de obra.', 'en' => 'Unit repair with parts and labour warranty.'],
                    ['es' => 'Carga de gas refrigerante para un rendimiento óptimo.', 'en' => 'Refrigerant recharge for optimal performance.'],
                    ['es' => 'Diagnóstico y solución de problemas técnicos en su sistema.', 'en' => 'Diagnosis and resolution of technical problems in your system.'],
                    ['es' => 'Limpieza y desinfección de filtros y conductos para mejorar la calidad del aire.', 'en' => 'Cleaning and disinfection of filters and ducts to improve air quality.'],
                    ['es' => 'Asesoramiento personalizado para elegir el equipo adecuado según sus necesidades.', 'en' => 'Personalised advice to choose the right equipment for your needs.'],
                    ['es' => 'Servicio de emergencia disponible para reparaciones urgentes.', 'en' => 'Emergency service available for urgent repairs.'],
                ],
            ],
            [
                'slug' => 'electricidad',
                'slug_en' => 'electrical-services',
                'icono' => 'bolt',
                'orden' => 2,
                'titulo' => ['es' => 'Electricidad', 'en' => 'Electrical Services'],
                'hero_subtitulo' => ['es' => 'Instalación y Mantenimiento', 'en' => 'Installation and Maintenance'],
                'descripcion_corta' => [
                    'es' => 'Confíe en nuestros expertos para sus necesidades eléctricas. Ofrecemos instalación, reparación y mantenimiento, garantizando seguridad y eficiencia en su hogar o negocio. ¡Calidad asegurada!',
                    'en' => 'Trust our experts for your electrical needs. We offer installation, repair and maintenance, ensuring safety and efficiency in your home or business.',
                ],
                'descripcion_larga' => [
                    'es' => 'Instalación de sistemas eléctricos residenciales y comerciales con la máxima seguridad. Servicios de emergencia las 24 horas para reparaciones urgentes.',
                    'en' => 'Installation of residential and commercial electrical systems with maximum safety. 24-hour emergency services for urgent repairs.',
                ],
                'items' => [
                    ['es' => 'Instalación de sistemas eléctricos residenciales y comerciales.', 'en' => 'Installation of residential and commercial electrical systems.'],
                    ['es' => 'Reparación de cortocircuitos y fallas eléctricas.', 'en' => 'Repair of short circuits and electrical faults.'],
                    ['es' => 'Actualización de paneles eléctricos obsoletos.', 'en' => 'Upgrade of obsolete electrical panels.'],
                    ['es' => 'Instalación de iluminación interior y exterior.', 'en' => 'Interior and exterior lighting installation.'],
                    ['es' => 'Cableado estructurado para redes informáticas.', 'en' => 'Structured cabling for computer networks.'],
                    ['es' => 'Instalación de sistemas de seguridad y cámaras de vigilancia.', 'en' => 'Installation of security systems and surveillance cameras.'],
                    ['es' => 'Servicios de emergencia las 24 horas para reparaciones urgentes.', 'en' => '24-hour emergency services for urgent repairs.'],
                ],
            ],
            [
                'slug' => 'fontaneria',
                'slug_en' => 'plumbing',
                'icono' => 'droplet',
                'orden' => 3,
                'titulo' => ['es' => 'Fontanería', 'en' => 'Plumbing'],
                'hero_subtitulo' => ['es' => 'Instalación y Mantenimiento', 'en' => 'Installation and Maintenance'],
                'descripcion_corta' => [
                    'es' => 'Nuestros servicios de fontanería incluyen instalación, reparación y mantenimiento, asegurando el funcionamiento óptimo de sus sistemas de agua y gas. Experiencia y calidad para su tranquilidad.',
                    'en' => 'Our plumbing services include installation, repair and maintenance, ensuring optimal operation of your water and gas systems.',
                ],
                'descripcion_larga' => [
                    'es' => 'Fontaneros experimentados preparados para abordar cualquier desafío, desde fugas hasta instalaciones completas de sistemas de agua caliente.',
                    'en' => 'Experienced plumbers ready to tackle any challenge, from leaks to complete hot water system installations.',
                ],
                'items' => [
                    ['es' => 'Instalación de tuberías y sistemas de agua potable.', 'en' => 'Installation of pipes and drinking water systems.'],
                    ['es' => 'Reparación de fugas y roturas en tuberías.', 'en' => 'Repair of leaks and pipe breaks.'],
                    ['es' => 'Mantenimiento de sistemas de calefacción y calentadores de agua.', 'en' => 'Maintenance of heating systems and water heaters.'],
                    ['es' => 'Instalación de grifería y sanitarios.', 'en' => 'Installation of taps and sanitary ware.'],
                    ['es' => 'Desatasco y limpieza de tuberías y desagües.', 'en' => 'Unblocking and cleaning of pipes and drains.'],
                    ['es' => 'Localización y reparación de problemas de humedad.', 'en' => 'Location and repair of damp problems.'],
                    ['es' => 'Instalación de sistemas de filtración y purificación de agua.', 'en' => 'Installation of water filtration and purification systems.'],
                ],
            ],
        ];

        foreach ($servicios as $data) {
            $items = $data['items'];
            unset($data['items']);

            $servicio = Servicio::query()->create($data);

            foreach ($items as $index => $item) {
                ServicioItem::query()->create([
                    'servicio_id' => $servicio->id,
                    'titulo' => ['es' => $item['es'], 'en' => $item['en']],
                    'orden' => $index + 1,
                ]);
            }
        }
    }
}
