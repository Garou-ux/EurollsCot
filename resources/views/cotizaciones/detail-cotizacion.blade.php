


   <div class="p-9">
    <div class="flex flex-col mx-0 mt-8">
        <div class="flex justify-between mt-4">
            {{-- <button id="agregarFila" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Agregar Fila</button> --}}
            <button id="guardarBtn" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Guardar</button>
        </div>
        <br/>
        <div id="jsGridReporteServicio" style="height:400%;"></div>
    <table class="min-w-full divide-y divide-slate-500"  >
      <thead>
      </thead>
      <tbody></tbody>
      <tfoot>
       <tr>
        <th scope="row" colspan="3" class="hidden pt-6 pl-6 pr-3 text-sm font-light text-right text-slate-500 sm:table-cell md:pl-0">
         Subtotal
        </th>
        <th scope="row"  class="pt-6 pl-4 pr-3 text-sm font-light text-left text-slate-500 sm:hidden">
         Subtotal
        </th>
        <td  id="subtotal" class="pt-6 pl-3 pr-4 text-sm text-right text-slate-500 sm:pr-6 md:pr-0">
         $0.00
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
         $0.00
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
         $0.00
        </td>
       </tr>
      </tfoot>
     </table>
    </div>
   </div>
