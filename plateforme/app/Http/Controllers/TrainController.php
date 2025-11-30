<?php

namespace App\Http\Controllers;

use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionOrale;
use App\Models\ExpressionEcrite;
use App\Models\ExpressionOrale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TrainController extends Controller
{
    // ================= Dashboard =================
    public function index()
    {
        $stats = [
            'total_questions' => ComprehensionEcrite::count() + ComprehensionOrale::count(),
            'oral_questions' => ComprehensionOrale::count(),
            'ecrite_tasks' => ExpressionEcrite::count() + ExpressionOrale::count(),
        ];

        $recent_ecrite = ComprehensionEcrite::latest()->take(3)->get();
        $recent_orale = ComprehensionOrale::latest()->take(3)->get();
        $recent_expression_ecrite = ExpressionEcrite::latest()->take(3)->get();
        $recent_expression_orale = ExpressionOrale::latest()->take(3)->get();

        return view('Admin.train_dashboard', compact(
            'stats',
            'recent_ecrite',
            'recent_orale',
            'recent_expression_ecrite',
            'recent_expression_orale'
        ));
    }

}
