<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use Illuminate\Database\Eloquent\Model;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function download()
    {
        $pdf = Invoice::make()
            ->name('Invoice')
            ->buyer(new Buyer([
                'name'          => 'John Doe',
                'custom_fields' => [
                    'Details' => 'Some custom details',
                    'Business ID' => '123456',
                ],
            ]))
            ->seller(new Party([
                'name'          => 'My Company',
                'address'       => '123 Main Street',
                'city'          => 'Anytown',
                'phone'         => '123-456-789',
                'custom_fields' => [
                    'Details' => 'Some custom details',
                    'Business ID' => '987654',
                ],
            ]))
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->currencyFormat('{VALUE} {SYMBOL}')
            ->dateFormat('m/d/Y')
            ->addItems([
                (new InvoiceItem())->title('Service 1')->pricePerUnit(100)->quantity(2),
                (new InvoiceItem())->title('Service 2')->pricePerUnit(200)->quantity(1),
            ])
            ->filename('invoice')
            ->save('public');
        return $pdf->download('invoice.pdf');
    }

    // the parameter $record is a type of Model
    public function viewPdf(Order $record)
    {
        $info = $record->attributesToArray();
        $client = new Party([
            'name'          =>  'IDK',
            'phone'         => '(520) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Party([
            'name'          => 'MTA',
            'address'       => 'The Green Street 12',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);

        $items = [
            InvoiceItem::make('Service 1')
                ->description('Your product or service description')
                ->pricePerUnit(47.01)
                ->quantity(2)

        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Bon de Commande')
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('$')
            ->currencyCode('USD')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/MondialLogo.png'));
        // You can additionally save generated invoice to configured disk

        $link = $invoice->url(); 
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return  $invoice->stream() ;
    }
}
