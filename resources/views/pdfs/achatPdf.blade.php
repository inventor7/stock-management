@extends('layouts.app', ['title' => $title, 'ref' => $data->id])

@section('content')
    <div class="container space-y-6 text-xs ">
        <div class=" flex flex-col justify-start items-start gap-2 w-full">
            <p>Ref: {{ $data->id }}</p>
            <p>Date: {{ $data->bon_achat_date }}</p>
        </div>
        <div class=" flex flex-row justify-between items-start  ">
            <div class=" flex flex-col justify-start items-start gap-2 w-full">
                <h1 class=" text-lg font-semibold ">Fournisseur </h1>
                <p>Nom : {{ $data->fournisseur->name }}</p>
                <p>Ref : {{ $data->fournisseur->id }}</p>
            </div>
            <div class=" flex flex-col justify-start items-start gap-2 w-full">
                <h1 class=" text-lg font-semibold ">Chauffeur </h1>
                <p>Nom : {{ $data->chauffeur->name }}</p>
                <p>Ref : {{ $data->chauffeur->id }}</p>
            </div>
            <div class=" flex flex-col justify-start items-start gap-2 w-full">
                <h1 class=" text-lg font-semibold ">Payement </h1>
                <p>Status: {{ $data->payment_status }}</p>
                <p>Date de Paiement: {{ $data->payment_date }}</p>
            </div>

        </div>

        <table class="w-full border-black table-auto text-xs ">
            <thead>
                <tr class="bg-sky-600 text-white">
                    <th class="px-4 py-1">ID item</th>
                    <th class="px-4 py-1">Nom d'item</th>
                    <th class="px-4 py-1">Prix Unitaire</th>
                    <th class="px-4 py-1">Quantité</th>
                    <th class="px-4 py-1">Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->achatitems as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-1">{{ $item->id }}</td>
                        <td class="border px-4 py-1">{{ $item->product->name }}</td>
                        <td class="border px-4 py-1">{{ $item->product->price }}</td>
                        <td class="border px-4 py-1">{{ $item->quantity }}</td>
                        <td class="border px-4 py-1">{{ $item->cost }}</td>
                    </tr>
                @endforeach
                <tr class="text-center text-gray-50 ">
                    <td class="border px-4 py-1">/</td>
                    <td class="border px-4 py-1">/</td>
                    <td class="border px-4 py-1">/</td>
                    <td class="border px-4 py-1">/</td>
                    <td class="border px-4 py-1">/</td>

                </tr>
                <tr class="text-center bg-gray-500 text-white">
                    <td class="border px-4 py-1"></td>
                    <td class="border px-4 py-1"></td>
                    <td class="border px-4 py-1"></td>
                    <td class="border px-4 py-1"> </td>
                    <td class="border font-semibold px-4 py-1">{{ $data->total }} DA</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
