@extends('layouts.app', ['title' => $title,'ref' => $data->id])

@section('content')
    <div class="container space-y-6 ">
        <div class="  rounded-lg ">
            <p>Status: {{$data->status}}</p>
            <p>Address: {{$data->adress}}, {{$data->commune}}, {{$data->wilaya}}</p>
            <p>Client Name: {{$data->client->name}}</p>
            <p>Leader Name: {{$data->leader->name}}</p>
        </div>

        <table class="w-full table-auto">
            <thead>
                <tr class="bg-sky-600 text-white">
                    <th class="px-4 py-2">Item ID</th>
                    <th class="px-4 py-2">Item Name</th>
                    <th class="px-4 py-2">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->orderitems as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{$item->id}}</td>
                        <td class="border px-4 py-2">{{$item->product->name}}</td>
                        <td class="border px-4 py-2">{{$item->quantity}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection