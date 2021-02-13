<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class Order extends Model
{
    protected $fillable = ['user_id', 'code', 'amount'];


    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateInvoice()
    {

//        $config = ['instanceConfigurator' => function ($mpdf) {
//            $mpdf->SetDisplayMode('none');
//
//        }];
        $pdf = \PDF::loadView('orders.invoice', ['order' => $this], [], ['display_mode' => 'fullpage']);
        return $pdf->save(storage_path('app/public/invoices/') . $this->id . '.pdf');
    }

    public function paid()
    {
        return $this->payment->status;
    }

    public function downloadInvoice()
    {
        return Storage::disk('public')->download('invoices/' . $this->id . '.pdf');
    }
}
