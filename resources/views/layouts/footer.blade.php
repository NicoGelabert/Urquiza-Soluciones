<footer>
    <div class="footer-container">
        <div class="flex flex-col items-center md:items-start gap-y-4">
            <div class="logo footer-logo">
                <x-application-logo />
                <x-social-icons />
            </div>
            <p class="">Málaga, Costa del Sol.</p>
        </div>
        <div class="footer-menu">
            <div>
                <a href="#servicios">
                    <h6>{{ __('Servicios') }}</h6>
                </a>
            </div>
            <div>
                <a href="#about">
                    <h6>{{ __('Sobre Nosotros') }}</h6>
                </a>
            </div>
            <div>
                <a href="#contact">
                    <h6>{{ __('Contacto') }}</h6>
                </a>
            </div>
            <div>
                <a href="tel:+34615338966">
                    <div class="btn-urgencies">
                    <i class="fi fi-rr-phone-call"></i>
                        <h6>{{ __('Urgencias') }}</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <hr class="footer-divider" />
    <div class="post-footer">
        <span class="developed-by">{{__('Sitio diseñado y desarrollado por')}}<a href="https://chimicreativo.es/" target="_blank"> Chimi Creativo</a></span>
        <ul class="flex gap-x-4">
            @foreach (Config::get('languages') as $lang => $language)
                @if ($lang != App::getLocale())
                    <li>
                        <a class="flex items-center gap-x-1 opacity-50" href="{{ route('lang.switch', $lang) }}">
                            <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span>
                            <span>{{$language['display']}}</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="flex items-center gap-x-1" href="{{ route('lang.switch', $lang) }}">
                            <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span>
                            <span>{{$language['display']}}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</footer>