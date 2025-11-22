<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;   // <-- FIXED
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[6-9]\d{9}$/',
            'loan_amount' => 'required|numeric|min:50000|max:5000000',
            'loan_type' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit Indian mobile number',
            'loan_amount.min' => 'Loan amount must be at least ₹50,000',
            'loan_amount.max' => 'Loan amount cannot exceed ₹50,00,000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'loan_amount' => $request->loan_amount,
                'loan_type' => $request->loan_type,
                'customer_message' => $request->message ?? 'No additional message provided.',
            ];

            Mail::send('emails.contact', $emailData, function($message) use ($request) {
                $message->to('p.sureshkk4620@gmail.com')
                        ->subject('New Loan Application - ' . $request->loan_type)
                        ->replyTo($request->email, $request->name);
            });

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully. We will contact you soon!'
            ]);

        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to send email. Please try again later.'
            ], 500);
        }
    }
}
