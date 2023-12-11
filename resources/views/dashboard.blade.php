<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        {{-- <div class="mx-auto max-w-2xl py-16 sm:py-24 lg:max-w-none lg:py-32"> --}}
                           <h2 class="text-gray-900 text-base font-semibold"> Accesos Rapidos </h2>
                            <div class="mt-6 space-y-12 lg:grid lg:grid-cols-3 lg:gap-x-6 lg:space-y-0">
                            <div class="group relative">
                                <div class="relative h-80 w-full overflow-hidden rounded-lg bg-white sm:aspect-h-1 sm:aspect-w-2 lg:aspect-h-1 lg:aspect-w-1 group-hover:opacity-75 sm:h-64">
                                <img
                                    src="{{ asset('assets/invoice_menu.jpg') }}"
                                    alt="Desk with leather desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug."
                                    class="h-full w-full object-cover object-center"
                                >
                                </div>
                                <h3 class="mt-6 text-sm text-gray-500">
                                <a
                                    href="{{ route('cotizaciones.list') }}"
                                >
                                    <span
                                        class="absolute inset-0">
                                    </span>
                                    Cotizaciones
                                </a>
                                </h3>
                                <p class="text-base font-semibold text-gray-900">Crea y Edita Cotizaciones</p>
                            </div>
                            </div>
                        {{-- </div> --}}
                        </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>
