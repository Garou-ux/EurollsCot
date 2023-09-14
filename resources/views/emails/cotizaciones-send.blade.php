<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />

                    <p class="text-xl font-extrabold tracking-tight uppercase font-body">
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
                    <p>{{ $header->direccion  }}</p>
                    <p>{{ $header->correo }}</p>
                    <p>{{ $header->telefono }}</p>
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
                    <p> {{ $header->created_at }} </p>

                    <p class="mt-2 text-sm font-normal text-slate-700">
                        Atención
                    </p>
                    <p>{{ $header->atencion }}</p>
                    </div>
                    <div class="text-sm font-light text-slate-500">
                    <p class="text-sm font-normal text-slate-700">Terminos</p>
                    <p>{{ $header->terminos }}</p>

                    {{-- <p class="mt-2 text-sm font-normal text-slate-700">Due</p>
                    <p>00.00.00</p> --}}
                    </div>
                    </div>
                    </div>
                </div>

                <div class="p-9">
                    <div class="flex flex-col mx-0 mt-8">
                    <table class="min-w-full divide-y divide-slate-500">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-normal text-slate-700 sm:pl-6 md:pl-0">
                            Material
                            </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-normal text-slate-700 sm:pl-6 md:pl-0">
                        Comentario
                        </th>
                        <th scope="col" class=" py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
                        Cantidad
                        </th>
                        <th scope="col" class=" py-3.5 px-3 text-right text-sm font-normal text-slate-700 sm:table-cell">
                        Precio
                        </th>
                        <th scope="col" class="py-3.5 pl-3 pr-4 text-right text-sm font-normal text-slate-700 sm:pr-6 md:pr-0">
                        Importe
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach ($detail as $detail )
                        <tr class="border-b border-slate-200">
                            <td class="py-4 pl-4 pr-3 text-sm sm:pl-6 md:pl-0">
                            {{-- <div class="font-medium text-slate-700">Tesla Truck</div> --}}
                            <div class="mt-0.5 text-slate-500 sm:hidden">
                            {{ $detail->clave }}
                            </div>
                            </td>
                            <td class=" px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                                {{ $detail->comentario }}
                            </td>
                            <td class=" px-3 py-4 text-sm text-right text-slate-500 sm:table-cell">
                             {{ $detail->cantidad }}
                            </td>
                            <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                {{ $detail->precio }}
                            </td>

                            <td class="py-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                                {{ $detail->importe }}
                            </td>
                        </tr>
                        @php
                            $subtotal += $detail->importe;
                        @endphp
                        @endforeach
                    <!-- Here you can write more products/tasks that you want to charge for-->
                    </tbody>
                    <tfoot>
                        <tr>
                         <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
                          Subtotal
                         </th>
                         <th scope="row"  class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
                          Subtotal
                         </th>
                         <td  id="subtotal" class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                             ${{ round($subtotal, 2) }}
                         </td>
                        </tr>
                        <tr>
                         <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
                          Iva
                         </th>
                         <th scope="row" class="pt-4 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
                          Iva
                         </th>
                         <td id="iva" class="pt-4 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
                          @php
                              $iva = $subtotal / 1.16;
                          @endphp
                          ${{ round($iva,2) }}
                         </td>
                        </tr>
                        <tr>
                         <th scope="row" colspan="3" class="hidden pt-4 pl-6 pr-3 text-sm font-normal text-right text-slate-700 sm:table-cell md:pl-0">
                          Total
                         </th>
                         <th scope="row"  class="pt-4 pl-4 pr-3 text-sm font-normal text-left text-slate-700 sm:hidden">
                          Total
                         </th>
                         <td id="total" class="pt-4 pl-3 pr-4 text-sm font-normal text-right text-slate-700 sm:pr-6 md:pr-0">
                          @php
                              $total = $subtotal + $iva;
                          @endphp
                          ${{ round($total, 2) }}
                         </td>
                        </tr>
                       </tfoot>
                    </table>
                    </div>
                </div>
                <div class="mt-48 p-9">
                    <div class="border-t pt-9 border-slate-200">
                     <div class="text-sm font-light text-slate-700">
                      <p>
                        Observations:
                        Working Hours: Monday to friday 8:00 a 18:00 hours. Rush jobs, cause extra fees.
                        Variations of 5% of the exchange rate modifies the proposal
                        After accepting the material, no changes of refunds are accepted
                        In case of cancellation, the purchase order will cause a charge o 20% of its total value
                      </p>
                     </div>
                    </div>
                   </div>
                </div>
                </article>
                </div>
            </section>

        </div>
    </div>
</body>
</html>
