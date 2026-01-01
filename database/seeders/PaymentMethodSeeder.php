<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'name' => 'BCA', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                'order' => 1,
            ],
            [
                'name' => 'Mandiri', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg',
                'order' => 2,
            ],
            [
                'name' => 'BNI', 
                'image' => 'https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg',
                'order' => 3,
            ],
            [
                'name' => 'BRI', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg',
                'order' => 4,
            ],
            [
                'name' => 'Visa', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg',
                'order' => 5,
            ],
            [
                'name' => 'Mastercard', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg',
                'order' => 6,
            ],
            [
                'name' => 'QRIS', 
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg', 
                'order' => 7,
            ],
        ];

        foreach ($payments as $pay) {
            PaymentMethod::create($pay);
        }
    }
}