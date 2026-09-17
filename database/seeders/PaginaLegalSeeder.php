<?php

namespace Database\Seeders;

use App\Models\PaginaLegal;
use Illuminate\Database\Seeder;

class PaginaLegalSeeder extends Seeder
{
    public function run(): void
    {
        $holder = config('legal.holder');
        $email = config('legal.contact_email');

        $pages = [
            [
                'slug' => 'aviso-legal',
                'titulo' => ['es' => 'Aviso legal', 'en' => 'Legal notice'],
                'contenido' => [
                    'es' => "<h2>1. Datos identificativos</h2><p>En cumplimiento del artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y Comercio Electrónico (LSSI-CE), se informa que el titular de este sitio web es <strong>{$holder}</strong>, con domicilio en Málaga (España) y correo electrónico de contacto <strong>{$email}</strong>.</p><h2>2. Objeto</h2><p>El presente aviso legal regula el uso y utilización del sitio web urquizasoluciones.es, del que es titular {$holder}.</p><h2>3. Condiciones de uso</h2><p>El acceso y uso de este sitio web atribuye la condición de usuario e implica la aceptación plena de las condiciones aquí establecidas.</p><h2>4. Propiedad intelectual</h2><p>Los contenidos de este sitio web, incluyendo textos, imágenes y diseño, están protegidos por la legislación vigente en materia de propiedad intelectual.</p><h2>5. Responsabilidad</h2><p>{$holder} no se hace responsable de los daños derivados del uso incorrecto de la información contenida en este sitio web.</p>",
                    'en' => "<h2>1. Identification</h2><p>In compliance with applicable regulations, the owner of this website is <strong>{$holder}</strong>, located in Málaga (Spain), contact email <strong>{$email}</strong>.</p><h2>2. Purpose</h2><p>This legal notice governs the use of the website urquizasoluciones.es, owned by {$holder}.</p><h2>3. Terms of use</h2><p>Access to and use of this website implies full acceptance of the conditions set out herein.</p><h2>4. Intellectual property</h2><p>The contents of this website, including texts, images and design, are protected by applicable intellectual property laws.</p><h2>5. Liability</h2><p>{$holder} is not liable for damages arising from incorrect use of the information contained on this website.</p>",
                ],
            ],
            [
                'slug' => 'privacidad',
                'titulo' => ['es' => 'Política de privacidad', 'en' => 'Privacy policy'],
                'contenido' => [
                    'es' => "<h2>1. Responsable del tratamiento</h2><p>El responsable del tratamiento de sus datos personales es <strong>{$holder}</strong>, con email de contacto <strong>{$email}</strong>.</p><h2>2. Finalidad</h2><p>Los datos recogidos a través de los formularios de contacto y presupuesto serán tratados con la finalidad de gestionar su solicitud y mantener la relación comercial.</p><h2>3. Legitimación</h2><p>La base legal para el tratamiento es el consentimiento del interesado y la ejecución de medidas precontractuales.</p><h2>4. Conservación</h2><p>Los datos se conservarán mientras se mantenga la relación comercial o durante el plazo legalmente establecido.</p><h2>5. Derechos</h2><p>Puede ejercer sus derechos de acceso, rectificación, supresión, limitación, oposición y portabilidad enviando un email a {$email}.</p>",
                    'en' => "<h2>1. Data controller</h2><p>The controller of your personal data is <strong>{$holder}</strong>, contact email <strong>{$email}</strong>.</p><h2>2. Purpose</h2><p>Data collected through contact and quote forms will be processed to manage your request and maintain the commercial relationship.</p><h2>3. Legal basis</h2><p>The legal basis for processing is the consent of the data subject and the execution of pre-contractual measures.</p><h2>4. Retention</h2><p>Data will be retained while the commercial relationship is maintained or for the legally established period.</p><h2>5. Rights</h2><p>You may exercise your rights of access, rectification, erasure, restriction, objection and portability by emailing {$email}.</p>",
                ],
            ],
            [
                'slug' => 'cookies',
                'titulo' => ['es' => 'Política de cookies', 'en' => 'Cookie policy'],
                'contenido' => [
                    'es' => "<h2>1. ¿Qué son las cookies?</h2><p>Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita un sitio web.</p><h2>2. Cookies que utilizamos</h2><p>Este sitio puede utilizar cookies técnicas necesarias para el funcionamiento del sitio, cookies analíticas (Google Analytics) para medir el tráfico y cookies de preferencias para recordar el idioma seleccionado.</p><h2>3. Gestión de cookies</h2><p>Puede configurar su navegador para rechazar cookies o eliminar las ya instaladas. Tenga en cuenta que algunas funcionalidades del sitio pueden verse afectadas.</p><h2>4. Más información</h2><p>Para cualquier consulta sobre el uso de cookies, contacte con {$email}.</p>",
                    'en' => "<h2>1. What are cookies?</h2><p>Cookies are small text files stored on your device when you visit a website.</p><h2>2. Cookies we use</h2><p>This site may use technical cookies necessary for operation, analytics cookies (Google Analytics) to measure traffic, and preference cookies to remember the selected language.</p><h2>3. Cookie management</h2><p>You can configure your browser to reject cookies or delete those already installed. Note that some site features may be affected.</p><h2>4. More information</h2><p>For any questions about cookie use, contact {$email}.</p>",
                ],
            ],
        ];

        foreach ($pages as $page) {
            PaginaLegal::query()->create($page);
        }
    }
}
