<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailValidationService;

class EmailValidationController extends Controller
{
    /**
     * Check email uniqueness via AJAX
     */
    public function checkEmailUniqueness(Request $request)
    {
        $email = $request->input('email');
        $field = $request->input('field');
        
        if (!$email) {
            return response()->json(['unique' => true]);
        }
        
        $isUnique = EmailValidationService::isEmailUnique($email);
        
        return response()->json([
            'unique' => $isUnique,
            'email' => $email,
            'field' => $field,
            'message' => $isUnique ? 'Email tersedia' : 'Email ini telah digunakan dalam sistem'
        ]);
    }
    
    /**
     * Get email occurrences for debugging
     */
    public function getEmailOccurrences(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['error' => 'Email required']);
        }
        
        $occurrences = EmailValidationService::getEmailOccurrences($email);
        
        return response()->json([
            'email' => $email,
            'occurrences' => $occurrences,
            'total' => array_sum($occurrences)
        ]);
    }
}
