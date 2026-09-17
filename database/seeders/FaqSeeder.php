<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Servicio;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $aires = Servicio::query()->where('slug', 'aires-acondicionados')->first();
        $electricidad = Servicio::query()->where('slug', 'electricidad')->first();
        $fontaneria = Servicio::query()->where('slug', 'fontaneria')->first();

        $faqs = [
            [$aires, [
                [
                    'es' => ['p' => '¿Cuándo debo realizar el mantenimiento de mi aire acondicionado?', 'r' => 'Se recomienda realizar el mantenimiento anualmente para asegurar un funcionamiento eficiente y prolongar su vida útil.'],
                    'en' => ['p' => 'When should I maintain my air conditioner?', 'r' => 'Annual maintenance is recommended to ensure efficient operation and extend its lifespan.'],
                ],
                [
                    'es' => ['p' => '¿Qué debo hacer si mi aire acondicionado no enfría adecuadamente?', 'r' => 'Puede ser necesario revisar el filtro de aire y limpiarlo. También se recomienda verificar el nivel de gas refrigerante y el estado de las bobinas del evaporador y condensador.'],
                    'en' => ['p' => 'What should I do if my air conditioner is not cooling properly?', 'r' => 'You may need to check and clean the air filter. It is also recommended to verify the refrigerant level and the condition of the evaporator and condenser coils.'],
                ],
                [
                    'es' => ['p' => '¿Cuál es la vida útil promedio de un aire acondicionado?', 'r' => 'La vida útil puede variar dependiendo del modelo y el mantenimiento, pero generalmente se estima entre 10 y 15 años.'],
                    'en' => ['p' => 'What is the average lifespan of an air conditioner?', 'r' => 'Lifespan varies depending on the model and maintenance, but is generally estimated at 10 to 15 years.'],
                ],
                [
                    'es' => ['p' => '¿Es necesario cargar el gas refrigerante regularmente?', 'r' => 'Solo se debe cargar el gas refrigerante si hay una fuga detectada. Un sistema de aire acondicionado bien mantenido no debería requerir cargas regulares.'],
                    'en' => ['p' => 'Is it necessary to recharge refrigerant regularly?', 'r' => 'Refrigerant should only be recharged if a leak is detected. A well-maintained system should not require regular recharges.'],
                ],
                [
                    'es' => ['p' => '¿Puedo instalar un aire acondicionado por mi cuenta?', 'r' => 'Se recomienda contar con instaladores profesionales para asegurar una instalación adecuada y cumplir con las normativas de seguridad.'],
                    'en' => ['p' => 'Can I install an air conditioner myself?', 'r' => 'Professional installers are recommended to ensure proper installation and compliance with safety regulations.'],
                ],
            ]],
            [$electricidad, [
                [
                    'es' => ['p' => '¿Cuándo debo actualizar mi panel eléctrico?', 'r' => 'Debe considerar una actualización si experimenta frecuentes cortocircuitos, fusibles que se queman o si su panel es antiguo y no cumple con las normativas actuales.'],
                    'en' => ['p' => 'When should I upgrade my electrical panel?', 'r' => 'Consider an upgrade if you experience frequent short circuits, blown fuses, or if your panel is old and does not meet current regulations.'],
                ],
                [
                    'es' => ['p' => '¿Qué debo hacer ante un apagón repentino en mi casa?', 'r' => 'Verifique si es un problema general en su área o específico de su hogar. Si es en su casa, revise el interruptor principal y contacte a un electricista si es necesario.'],
                    'en' => ['p' => 'What should I do in case of a sudden power outage at home?', 'r' => 'Check if it is a general area problem or specific to your home. If it is in your house, check the main switch and contact an electrician if necessary.'],
                ],
                [
                    'es' => ['p' => '¿Es seguro realizar reparaciones eléctricas por mi cuenta?', 'r' => 'No se recomienda. Las reparaciones eléctricas requieren conocimientos técnicos y pueden ser peligrosas si no se realizan correctamente.'],
                    'en' => ['p' => 'Is it safe to do electrical repairs myself?', 'r' => 'It is not recommended. Electrical repairs require technical knowledge and can be dangerous if not done correctly.'],
                ],
                [
                    'es' => ['p' => '¿Cómo puedo mejorar la eficiencia energética en mi hogar?', 'r' => 'Instalando iluminación LED, dispositivos de control de temperatura como termostatos inteligentes y asegurándose de que los electrodomésticos estén eficientemente calificados.'],
                    'en' => ['p' => 'How can I improve energy efficiency in my home?', 'r' => 'By installing LED lighting, temperature control devices such as smart thermostats, and ensuring appliances are energy efficient.'],
                ],
                [
                    'es' => ['p' => '¿Qué debo hacer si tengo un enchufe que no funciona?', 'r' => 'Primero, verifique si el interruptor correspondiente está encendido. Si el problema persiste, podría ser necesario revisar el cableado o el propio enchufe con la ayuda de un electricista.'],
                    'en' => ['p' => 'What should I do if I have a socket that does not work?', 'r' => 'First, check if the corresponding switch is on. If the problem persists, the wiring or the socket itself may need to be checked with the help of an electrician.'],
                ],
            ]],
            [$fontaneria, [
                [
                    'es' => ['p' => '¿Cómo puedo prevenir las obstrucciones en mis tuberías?', 'r' => 'Evite arrojar residuos sólidos por el desagüe y use protectores de desagüe en los fregaderos. Además, realice limpiezas periódicas con productos desatascadores.'],
                    'en' => ['p' => 'How can I prevent blockages in my pipes?', 'r' => 'Avoid throwing solid waste down the drain and use drain guards in sinks. Also perform periodic cleanings with unblocking products.'],
                ],
                [
                    'es' => ['p' => '¿Qué debo hacer si tengo una fuga de agua en mi hogar?', 'r' => 'Cierre inmediatamente la válvula principal de agua para evitar daños adicionales y contacte a un fontanero profesional para reparar la fuga.'],
                    'en' => ['p' => 'What should I do if I have a water leak at home?', 'r' => 'Immediately close the main water valve to prevent further damage and contact a professional plumber to repair the leak.'],
                ],
                [
                    'es' => ['p' => '¿Cómo puedo mejorar la presión del agua en mi casa?', 'r' => 'Asegúrese de que las válvulas de cierre parcial no estén cerradas por completo y considere la instalación de una bomba de agua si la presión es constantemente baja.'],
                    'en' => ['p' => 'How can I improve water pressure in my home?', 'r' => 'Make sure partial shut-off valves are not fully closed and consider installing a water pump if pressure is consistently low.'],
                ],
                [
                    'es' => ['p' => '¿Cuándo debo reemplazar mi calentador de agua?', 'r' => 'Generalmente, los calentadores de agua tienen una vida útil de 8 a 12 años. Considere reemplazarlo si muestra signos de deterioro, como fugas o falta de eficiencia.'],
                    'en' => ['p' => 'When should I replace my water heater?', 'r' => 'Water heaters generally have a lifespan of 8 to 12 years. Consider replacing it if it shows signs of deterioration, such as leaks or lack of efficiency.'],
                ],
                [
                    'es' => ['p' => '¿Cómo puedo evitar problemas congelación de tuberías en invierno?', 'r' => 'Aísle las tuberías expuestas y mantenga un ligero flujo de agua en los grifos durante las olas de frío.'],
                    'en' => ['p' => 'How can I prevent pipes from freezing in winter?', 'r' => 'Insulate exposed pipes and maintain a slight flow of water in taps during cold spells.'],
                ],
            ]],
        ];

        foreach ($faqs as [$servicio, $items]) {
            if (! $servicio) {
                continue;
            }

            foreach ($items as $index => $item) {
                Faq::query()->create([
                    'servicio_id' => $servicio->id,
                    'pregunta' => ['es' => $item['es']['p'], 'en' => $item['en']['p']],
                    'respuesta' => ['es' => $item['es']['r'], 'en' => $item['en']['r']],
                    'orden' => $index + 1,
                ]);
            }
        }
    }
}
