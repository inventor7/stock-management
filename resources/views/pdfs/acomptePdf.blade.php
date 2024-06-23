@extends('layouts.app', ['title' => $title, 'ref' => $data->id])

@section('content')
    <div class="container space-y-6 text-xs ">
        <div class=" flex flex-col justify-start items-start gap-2 w-full">
            <p>Ref: {{ $data->id }}</p>
            <p>Date: {{ $data->created_at->format('d M Y') }}</p>
        </div>

        <table class="w-full border-black table-auto text-xs ">
            <thead>
                <tr class="bg-sky-600 text-white">
                    <th class="px-4 py-1">Employé</th>
                    <th class="px-4 py-1">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->acomptes as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-1">{{ $item->id }}</td>
                        <td class="border px-4 py-1">{{ $item->employé->name }}</td>
                    </tr>
                @endforeach
                <tr class="text-center text-gray-50 ">
                    <td class="border px-4 py-1">/</td>
                    <td class="border px-4 py-1">/</td>

                </tr>
                <tr class="text-center bg-gray-500 text-white">
                    <td class="border px-4 py-1"> </td>
                    <td class="border font-semibold px-4 py-1">{{ $data->total }} DA</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
