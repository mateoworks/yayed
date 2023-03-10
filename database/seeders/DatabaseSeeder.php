<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CategoryMovement;
use App\Models\Colonia;
use App\Models\Document;
use App\Models\Endorsement;
use App\Models\Job;
use App\Models\Loan;
use App\Models\Movement;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\Solicitud;
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
        \App\Models\User::factory()->create(['email' => 'gladis@yayed.com', 'id' => '1']);
        \App\Models\User::factory(10)->create();
        Job::factory(10)->create();
        Colonia::factory(5)->create();
        Partner::factory(20)->create();
        Document::factory(30)->create();
        Endorsement::factory(10)->create();
        Solicitud::factory(30)->create()->each(function ($solicitud) {
            $solicitud->endorsements()->sync(Endorsement::all()->random(2));
        });
        Loan::factory(30)->create();
        Payment::factory(150)->create();
        CategoryMovement::factory(10)->create();
        Movement::factory(40)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
