<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;
    public function definition(): array
    {
        return [
            'type' => 'asset',
            'document_number' => 'DOC-'.$this->faker->date('Ymd').'-'.str_pad($this->faker->numberBetween(1,9999),4,'0',STR_PAD_LEFT),
            'document_date' => now()->toDateString(),
            'overall_status' => 'pending',
        ];
    }
}
