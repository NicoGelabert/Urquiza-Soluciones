
<div x-data="serviceApp()" x-init="init()" class="container flex flex-col md:flex-row items-start gap-8" id="services">
    <!-- Columna derecha: Listado de botones -->
    <div class="w-full md:w-1/2 flex flex-col gap-4">
        <template x-for="service in services" :key="service.id">
            <button
                :class="selectedService && selectedService.id === service.id ? 'service-button-active service-button' : 'service-button'"
                @click="selectService(service)"
            >
                <div class="flex items-center">
                    <!-- Ícono del servicio -->
                    <i :class="service.icon" class="service-icon"></i>
                    <!-- Nombre del servicio -->
                    <span x-text="service.name"></span>
                </div>
                <!-- Círculo con una flecha dentro -->
                <div class="service-bg-arrow">
                    <i class="fi fi-rr-arrow-small-right rotate-90 md:rotate-0"></i>
                </div>
            </button>
        </template>
    </div>
    
    <!-- Columna izquierda: Detalles del servicio seleccionado -->
    <div class="w-full md:w-1/2 p-8 service-description">
        <template x-if="selectedService">
            <div class="flex flex-col justify-between h-full gap-4">
                <h2 class="text-2xl font-bold" x-text="selectedService.name"></h2>
                <!-- Lista de atributos -->
                <ul class="ml-4">
                    <template x-for="attribute in selectedService.attributes" :key="attribute.id">
                        <li class="mb-2 flex items-center gap-2">
                            <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.6157 0.372421C16.133 0.863738 16.1276 1.6551 15.6023 2.14017L7.87874 9.2749C7.3641 9.75872 6.68414 10 6.00284 10C5.32154 10 4.63625 9.75622 4.11494 9.26865L0.405808 5.89818C-0.123497 5.41687 -0.136829 4.62551 0.376477 4.13044C0.889783 3.63412 1.73374 3.62287 2.26171 4.10294L5.98551 7.48715L13.7304 0.359919C14.2584 -0.123898 15.0997 -0.120147 15.6157 0.372421Z" fill="#011627"/>
                            </svg>
                            <span x-text="attribute.text"></span>
                        </li>
                    </template>
                </ul>
                <x-button href="#"><span>Solicitar presupuesto</span></x-button>
            </div>
        </template>
        <template x-if="!selectedService">
            <p>Selecciona un servicio para ver los detalles.</p>
        </template>
    </div>
</div>

<script>
    function serviceApp() {
        return {
            services: [],
            selectedService: null,
            init() {
                fetch('/servicios')
                    .then(response => response.json())
                    .then(data => {
                        this.services = data;
                        // Seleccionar el primer servicio por defecto
                        if (this.services.length > 0) {
                            this.selectedService = this.services[0];
                        }
                    });
            },
            selectService(service) {
                this.selectedService = service;
            }
        }
    }
</script>
<!-- <div class="container flex flex-col gap-8" id="services">
    <div class="flex flex-col md:flex-row w-full justify-between gap-16">
        <div class="flex justify-between md:hidden">
            <div class="">
                <h3 class="text-center">Servicios</h3>
            </div>
            <i class="fi fi-br-arrow-up-left -rotate-90 text-4xl overflow-hidden"></i>
        </div>
        <div class="splide w-full md:w-10/12" id="home-services">
            <div class="splide__track w-full md:px-0  items-start">
                <ul class="splide__list">
                    @foreach ($services as $service)
                        <li class="card splide__slide mx-auto">
                            <div class="imgBx" style="background-image:url({{ $service->image }})">
                                <span class="price"><h4>0{{ $service->id }}</h4></span>
                            </div>
                            <div class="content">
                                <div class="card-title">
                                    <h5>{{ $service->name }}</h5>
                                    <a href="{{ route('service.view', $service->slug) }}"><i class="fi fi-sr-add"></i></a>
                                </div>
                                <div>
                                    <p>{!! $service->description !!}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="hidden md:flex flex-col justify-between">
            <div class="h-fit vertical-text ">
                <h3 class="text-center">Servicios</h3>
            </div>
            <i class="fi fi-br-arrow-up-left text-4xl overflow-hidden"></i>
        </div>
    </div>
    <div class="flex justify-end">
        <p class="text-right text-2xl">Diseño creativo para satisfacer<br>sus necesidades.</p>
    </div>
</div> -->