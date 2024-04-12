<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Adress;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class PdfController extends Controller
{
    public function download(Order $order)
    {
        //attach more vars to the $order like client using relations in the order model with optimizatioon when seraching the order like limit(1)

        $order->client = Order::with('client')->where('id', $order->id)->first()->client;
        $order->leader = Order::with('leader')->where('id', $order->id)->first()->leader;
        $order->orderitems = Order::with('orderitems')->where('id', $order->id)->first()->orderitems;

        $order->wilaya = Adress::where('wilaya_code', $order->wilaya)->first()->wilaya_name_ascii;
        //for each order item, attach the product to it
        foreach ($order->orderitems as $orderitem) {
            $orderitem->product = Order::with('orderitems.product')->where('id', $order->id)->first()->orderitems->where('id', $orderitem->id)->first()->product;
            $orderitem->cost = $orderitem->product->price *  $orderitem->quantity;
            $order->total = $orderitem->cost + $order->total;
        }
        return Pdf::view('pdfs.orderPdf', ['data' => $order, 'title' => 'de Commande'])
            ->format('a4')
            ->name('Order-' . $order->id . '-pdf');
    }
}
