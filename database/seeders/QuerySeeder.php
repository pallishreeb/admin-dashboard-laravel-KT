<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Add this line

class QuerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('queries')->insert([
            'product_id' => 5,
            'user_name' => 'John Doe',
            'mobile' => '1234567890',
            'email' => 'john.doe@example.com',
            'query_message' => 'I have a question about the product.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('queries')->insert([
            'product_id' => 5,
            'user_name' => 'Ram Das',
            'mobile' => '1234567890',
            'email' => 'john.doe@example.com',
            'query_message' => 'I have a question about the product.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('queries')->insert([
            'product_id' => 6,
            'user_name' => 'Hari AB',
            'mobile' => '1234567890',
            'email' => 'john.doe@example.com',
            'query_message' => 'I have a question about the product.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
