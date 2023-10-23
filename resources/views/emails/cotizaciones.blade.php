<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://cdn.tailwindcss.com/3.1.0/tailwind.min.css');
    </style>

</head>

<body class="font-sans antialiased">
    <!-- Contenido de tu página aquí -->
    <div style="margin-top: -150px;" class="min-h-screen bg-gray-100">
        <div class="py-6">
            <section class="py-20 bg-black">
                <div class="max-w-5xl mx-auto py-16 bg-white">
                <article class="overflow-hidden">
                <div class="bg-[white] rounded-b-md">
                <div class="p-9">
                    <div class="space-y-6 text-slate-700">
                        <div class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" >
                            @if ($company_id === 1)
                                <img src="{{ asset('assets/onemfg_logo.png') }}" alt="Logo" class="w-16 h-16 rounded">
                            @else
                                <img src="{{ asset('assets/prescition.png') }}" alt="Logo" class="w-18 h-16 rounded">
                            @endif
                        </div>

                    <p class="text-xl font-extrabold tracking-tight uppercase font-body" style="font-size: 1.25rem; font-weight: 800; letter-spacing: 0.025em;">
                        {{-- One Mfg Cotización #  --}}
                        {{ __('Cotizacion #') }} {{ $header->id }}
                    </p>
                    </div>
                </div>
                <div class="p-9">
                    <div class="flex w-full">
                    <div class="grid grid-cols-4 gap-12">
                    <div class="text-sm font-light text-slate-500">
                    <p class="text-sm font-normal text-slate-700">
                        Detalle Cliente:
                    </p>
                    <p>Direccion:</p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->direccion  }}</p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->correo }}</p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->telefono }}</p>
                    </div>
                    <div class="text-sm font-light text-slate-500">
                        <p class="text-sm font-normal text-slate-700">One Mfg</p>
                        <p>Valle alto 203 Col. Valle del Mezquital</p>
                        <p>Apodaca N.L. C.P.66632</p>
                        <p>tel.-+52(81)13-64-32-30 & 83-14-06-14</p>
                        <p>H. Alejandro Badillo</p>
                    </div>
                    <div class="text-sm font-light text-slate-500">
                    <p class="text-sm font-normal text-slate-700">Fecha</p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->created_at }}</p>

                    <p class="mt-2 text-sm font-normal text-slate-700">
                        Atención
                    </p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->atencion }}</p>
                    </div>
                    <div class="text-sm font-light text-slate-500">
                    <p class="text-sm font-normal text-slate-700">Terminos</p>
                    <p style="font-size: 0.875rem; font-weight: 400; line-height: 1.25rem;">{{ $header->terminos }}</p>
                    </div>
                    </div>
                    </div>
                </div>

                <!-- ... Tu contenido restante ... -->

                </article>
                </div>
            </section>

        </div>
    </div>
</body>
</html>
