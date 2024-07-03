<div class="home-hero-banner splide" aria-label="Urquiza Soluciones">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach($homeherobanners as $homeherobanner)
            <li class="splide__slide mx-auto">
                <div class="flex flex-col justify-center md:items-stretch gap-12 max-w-screen-xl px-4 pt-6 md:pt-16 mx-auto xl:px-0 md:flex-row">
                    <div class="flex flex-col justify-center gap-6 lg:gap-12 w-full md:w-1/2">
                        <div class="flex gap-4 items-center animate-icon">
                            <i class="{{ $homeherobanner->service }}"></i>
                            <p>{{ $homeherobanner->title }}</p>
                        </div>
                        <h1 class="animate-h1 text-4xl md:text-6xl leading-tight font-bold">{{ $homeherobanner->headline }}</h1>
                        <p class="animate-p">{{ $homeherobanner->description }}</p>
                        <div class="animate-button flex gap-4">
                            <x-button href="{{ $homeherobanner->link }}"><span>Solicitar presupuesto</span></x-button>
                            <x-button href="{{ $homeherobanner->link }}" class="btn-secondary"><i class="fi fi-rr-arrow-small-right arrow-to-right"></i><span>Ver servicio</span></x-button>
                        </div>
                    </div>
                    <div class="flex w-full md:w-1/2 h-auto overflow-hidden justify-end">
                        <div class="">
                            <img src="{{ $homeherobanner->image }}" alt="{{ $homeherobanner->title }}" class="animate-img max-h-[450px]">
                        </div>
                        <div class="h-fit vertical-text ml-4">
                            <h6 class="animate-h5">Presupuesto sin cargo</h6>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>