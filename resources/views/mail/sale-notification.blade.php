@extends('mail.layouts.main')

@section('content')
    <h3 class="text-2xl">¡{{ __('Nueva venta registrada') }}!</h3>
    <div class="flex justify-center">
        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
        </svg> --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" viewBox="0 0 24 24" stroke="currentColor"
            fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
            <rect x="9" y="3" width="6" height="4" rx="2" />
            <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
            <path d="M12 17v1m0 -8v1" />
        </svg>
    </div>

    <div class="flex justify-center mt-4">
      <ul
          class="w-auto text-sm font-medium text-gray-900 bg-white rounded-lg border">
          <li class="py-2 px-4 w-full border-b border-gray-600">
            <span class="font-bold tracking-wider ml-r">{{ __('Servicio') }}</span>
            <span>{{ $sale->service }}</span>
          </li>
          <li class="py-2 px-4 w-full border-b border-gray-600">
            <span class="font-bold tracking-wider ml-r">{{ __('Cantidad') }}</span>
            <span>{{ $sale->count }}</span>
          </li>
          <li class="py-2 px-4 w-full border-b border-gray-600">
            <span class="font-bold tracking-wider ml-r">{{ __('Monto') }}</span>
            <span>{{ $sale->usd_amount }}</span>
          </li>
          <li class="py-2 px-4 w-full border-b border-gray-600">
            <span class="font-bold tracking-wider ml-r">{{ __('Cliente') }}</span>
            <span>{{ $sale->client }}</span>
          </li>
      </ul>
    </div>


    <div class="mt-4">
        <p class="mb-6">{{ __('Puede ver la venta realizada presionando el siguiente botón') }}</p>
        <a href="{{ route('sales.show', $sale->id) }}" class="px-4 py-4 text-blue-200 bg-blue-600 rounded-full">
            {{ __('Ver la venta') }}
        </a>
    </div>
@endsection
