@extends('mail.layouts.main')

@section('content')
    <h3 class="text-2xl">¡{{ __('Venta verificada') }}!</h3>
    <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <div class="flex justify-center mt-4">
        <ul class="w-auto text-sm font-medium text-gray-900 bg-white rounded-lg border">
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
