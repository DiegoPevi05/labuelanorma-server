<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'order_id',
        'user_id',
        'gross_import',
        'payment_method',
        'payment_code_1',
        'payment_code_2',
        'pdf_url',
        'status'
    ];
}
