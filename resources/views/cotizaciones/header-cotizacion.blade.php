<div class="p-9">
    <div class="flex w-full">
     <div class="grid grid-cols-4 gap-12">
        {{-- datos de cliente --}}
      <div class="text-sm font-light text-slate-500">
       <p class="text-sm font-normal text-slate-700">
        Detalle Cliente:
       </p>
       <p>Cliente:</p>
       <div class="relative">
        <select id="selectPicker" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
          <!-- Opciones se agregarán dinámicamente con JavaScript -->
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </div>
      </div>

       <h1> Direccion:</h1>
       <p id="direccion_cli"></p>
       <p id="email_cli"></p>
       <p id="codigo_postal"></p>
       {{-- fin datos de lciente --}}
      </div>

      {{-- datos empresa --}}
      <div class="text-sm font-light text-slate-500">
       <p class="text-sm font-normal text-slate-700">One Mfg</p>
       <p>Valle alto 203 Col. Valle del Mezquital</p>
       <p>Apodaca N.L. C.P.66632</p>
       <p>tel.-+52(81)13-64-32-30 & 83-14-06-14</p>
       <p>H. Alejandro Badillo</p>
      </div>
      {{-- fin datos empresa --}}
      <div class="text-sm font-light text-slate-500">
       <p class="text-sm font-normal text-slate-700">Fecha</p>
       <p> {{ now()->format('Y-m-d') }} </p>

       <p class="mt-2 text-sm font-normal text-slate-700">
        Atención
       </p>
       <input type="text" maxlength="30" name="atencion" id="atencion" required>
      </div>
      <div class="text-sm font-light text-slate-500">
       <p class="text-sm font-normal text-slate-700">Terminos</p>
       <p>Validity of quotation .- 15 days</p>
       <p>Payment 30 days ... - Currency MXP</p>
       <p>*Purchase order delay may affect delivery time*</p>
      </div>
     </div>
    </div>
   </div>
