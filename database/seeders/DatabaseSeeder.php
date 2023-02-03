<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Document;
use App\Models\Endorsement;
use App\Models\Loan;
use App\Models\Partner;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create(['email' => 'gladis@yayed.com']);
        \App\Models\User::factory(10)->create();
        Partner::factory(20)->create();
        Document::factory(30)->create();
        Endorsement::factory(10)->create();
        Loan::factory(30)->create()->each(function ($loan) {
            $loan->endorsements()->sync(Endorsement::all()->random(2));
        });
        Payment::factory(150)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
