@extends('layouts.app', ['title' => $title, 'ref' => $data->id])

@section('content')
    <div class="container space-y-6 text-xs ">
        <div class=" flex flex-col justify-start items-start gap-2 w-full">
            <p>Ref: {{ $data->id }}</p>
            <p>Date: {{ $data->created_at->format('d-M-Y') }}</p>
            <p>Wilaya: {{ $data->wilaya }}</p>
            <p>Address: {{ $data->adress }}, {{ $data->commune }}</p>
        </div>
        <div class=" flex flex-row justify-between items-start  ">
            <div class=" flex flex-col justify-start items-start gap-2 w-full">
                <h1 class=" text-lg font-semibold ">Client </h1>
                <p>Nom : {{ $data->client->name }}</p>
                <p>Ref : {{ $data->client->id }}</p>
                <p>Type : {{ $data->client->type }}</p>
            </div>
            <div class=" flex flex-col justify-start items-start gap-2 w-full">
                <h1 class=" text-lg font-semibold ">Atelier </h1>
                <p>Status: {{ $data->status }}</p>
                <p>Chef d'atelier: {{ $data->leader->name }}</p>
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
                @foreach ($data->orderitems as $item)
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
