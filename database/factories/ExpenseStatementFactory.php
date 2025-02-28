<?php

namespace Database\Factories;

use App\Models\ExpenseStatement;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseStatementFactory extends Factory
{
    protected $model = ExpenseStatement::class;

    public function definition()
    {
        // Ensure total_expense is less than or equal to total_grant_amount.
        $totalGrant = $this->faker->randomFloat(2, 500, 2000);
        $totalExpense = $this->faker->randomFloat(2, 100, $totalGrant);
        $deductions = $this->faker->randomFloat(2, 0, 100);

        return [
            'application_id'      => Application::factory(),
            'total_grant_amount'  => $totalGrant,
            'total_expense'       => $totalExpense,
            'deductions'          => $deductions,
        ];
    }
}
