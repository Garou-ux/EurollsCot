<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Cotizacion #') }} {{ $cotizacion_id->id }}
        </h2>

    </x-slot>
    <div class="py-6">
        <section class="py-20">
            <div class="max-w-5xl mx-auto py-16 bg-white">
             <article class="overflow-hidden">
              <div class="bg-[white] rounded-b-md">
               <div class="p-9">
                <div class="space-y-6 text-slate-700">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />

                 <p class="text-xl font-extrabold tracking-tight uppercase font-body">
                 One Mfg Cotización # {{ $cotizacion_id->id }}
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
    <input type="hidden" value="{{ route('cotizaciones.update') }}" id="url_update_cotizacion">
    <input type="hidden" value="{{ route('products.cotizacion') }}" id="url_get_products">
    <input type="hidden" value="{{ route('clientes.cotizacion') }}" id="url_get_clients">
    <input type="hidden" value="{{ route('cotizaciones.details') }}" id="url_get_details">
    <input type="hidden" value="{{ route('cotizaciones.pdf') }}" id="url_get_pdf">

    {{-- cotizaciones.pdf --}}
    <input type="hidden" value="{{ json_encode($cotizacion_id) }}" id="cotizacion_data">

    <script type="text/javascript" src="{{ asset('js/CtrlEditarCotizacion.js') }}"></script>
</x-app-layout>


