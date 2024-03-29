<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Cotizacion') }}
        </h2>

    </x-slot>
    <div class="py-6">
        <section class="py-20">
            <div class="max-w-5xl mx-auto py-16 bg-white">
             <article class="overflow-hidden">
              <div class="bg-[white] rounded-b-md">
               <div class="p-9">
                <div class="space-y-6 text-slate-700">
                    <div class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" >
                        @if ( intval($company_id) == 1)
                            <img src="{{ asset('assets/onemfg_logo.png') }}" alt="Logo" class="w-16 h-16 rounded">
                        @else
                            <img src="{{ asset('assets/prescition.png') }}" alt="Logo" class="w-18 h-16 rounded">
                        @endif
                    </div>

                 <p class="text-xl font-extrabold tracking-tight uppercase font-body">
                @if ( intval($company_id) == 1 )
                    One MFG Cotizacion
                @else
                   Prescision Manufacturing Cotizacion
                @endif
                 </p>
                </div>
               </div>
               @include('cotizaciones.header-cotizacion')
               @include('cotizaciones.detail-cotizacion')
               @include('cotizaciones.foot-cotizacion')
              </div>
             </article>
            </div>
           </section>
    </div>
    <input type="hidden" value="{{ route('cotizaciones.store') }}" id="url_store_cotizacion">
    <input type="hidden" value="{{ route('products.cotizacion') }}" id="url_get_products">
    <input type="hidden" value="{{ route('clientes.cotizacion') }}" id="url_get_clients">
    <input type="hidden" value="{{ route('cotizaciones.pdf') }}" id="url_get_pdf">
    <input type="hidden" value="{{ route('cotizaciones.email') }}" id="url_get_client_email">

        <script type="text/javascript" src="{{ asset('js/CtrlCotizaciones.js') }}"></script>
</x-app-layout>


