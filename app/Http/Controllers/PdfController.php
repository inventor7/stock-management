<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Order;
use App\Models\Adress;
use App\Models\Client;
 use App\Models\BonAcompte;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class PdfController extends Controller
{
    public function downloadOrder(Order $order)
    {
        //attach more vars to the $order like client using relations in the order model with optimizatioon when seraching the order like limit(1)
        $order->client = Order::with('client')->where('id', $order->id)->first()->client;
        $order->leader = Order::with('leader')->where('id', $order->id)->first()->leader;
        $order->orderitems = Order::with('orderitems')->where('id', $order->id)->first()->orderitems;




        //
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



    public function downloadAchat(Achat $achat)
    {
        //attach more vars to the $order like client using relations in the order model with optimizatioon when seraching the order like limit(1)

        $achat->client = Achat::with('fournisseur')->where('id', $achat->id)->first()->fournisseur;
        $achat->leader = Achat::with('chauffeur')->where('id', $achat->id)->first()->chauffeur;
        $achat->achatitems = Achat::with('achatitems')->where('id', $achat->id)->first()->achatitems;




        foreach ($achat->achatitems as $achatitem) {
            $achatitem->product = Achat::with('achatitems.product')->where('id', $achat->id)->first()->achatitems->where('id', $achatitem->id)->first()->product;
            $achatitem->cost = $achatitem->product->price *  $achatitem->quantity;
            $achat->total = $achatitem->cost + $achat->total;
        }
        return Pdf::view('pdfs.achatPdf', ['data' => $achat, 'title' => "d'Achat"])
            ->format('a4')
            ->name('Achat-' . $achat->id . '-pdf');
    }


    public function downloadBonAcompte(BonAcompte $bonAcompte)
    {
        $bonAcompte->acomptes = BonAcompte::with('acomptes')->where('id', $bonAcompte->id)->first()->acomptes;
        foreach ($bonAcompte->acomptes as $acompte) {

            $acompte->employé = BonAcompte::with('acomptes.worker')->where('id', $bonAcompte->id)->first()->acomptes->where('id', $acompte->id)->first()->worker;
            $bonAcompte->total = $acompte->amount + $bonAcompte->total;
        }

        return Pdf::view('pdfs.acomptePdf', ['data' => $bonAcompte, 'title' => "d'Acompte"])
            ->format('a4')
            ->save('../public/assets' . $bonAcompte->id . '.pdf')
            ->disk('local')
            ->name('Achat-' . $bonAcompte->id . '-pdf');
    }
}
