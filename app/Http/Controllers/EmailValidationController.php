<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailValidationService;
use Illuminate\Support\Facades\Validator;

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
    
    /**
     * Validate email for update operations (with user_id exclusion)
     */
    public function validateEmailForUpdate(Request $request)
    {
        $email = $request->input('email');
        $userId = $request->input('user_id');
        
        if (!$email) {
            return response()->json([
                'valid' => false,
                'message' => 'Email diperlukan'
            ]);
        }
        
        try {
            // Use the UniqueEmailAcrossAllTables rule for validation
            $rule = new \App\Rules\UniqueEmailAcrossAllTables($userId);
            
            $validator = Validator::make(['email' => $email], [
                'email' => ['required', 'email', $rule]
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'valid' => false,
                    'message' => $validator->errors()->first('email')
                ]);
            }
            
            return response()->json([
                'valid' => true,
                'message' => 'Email tersedia untuk digunakan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Ralat semasa memeriksa email: ' . $e->getMessage()
            ]);
        }
    }
}
