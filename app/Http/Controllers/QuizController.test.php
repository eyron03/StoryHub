<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\QuizController;
use App\Models\Children;
use App\Models\Parents;
use App\Models\QuizResult;
use App\Models\QuizAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Carbon\Carbon;

class QuizControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $quizController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->quizController = new QuizController();
    }
}
