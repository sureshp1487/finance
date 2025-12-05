<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;   // <-- FIXED
use App\Models\ContactSubmission;
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
            'loan_amount' => 'required|numeric|min:0|max:5000000',
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
            // Store in database with default 'pending' status
            $contactSubmission = ContactSubmission::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'loan_amount' => $request->loan_amount,
                'loan_type' => $request->loan_type,
                'message' => $request->message,
                'status' => ContactSubmission::STATUS_PENDING,
            ]);

            // Prepare email data
            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'loan_amount' => $request->loan_amount,
                'loan_type' => $request->loan_type,
                'customer_message' => $request->message ?? 'No additional message provided.',
                'submission_id' => $contactSubmission->id,
            ];

            // Send email
            Mail::send('emails.contact', $emailData, function($message) use ($request) {
                $message->to(['sgfinancetech@gmail.com','aruntech1996@gmail.com'])
                        ->subject('New Loan Application - ' . $request->loan_type)
                        ->replyTo($request->email, $request->name);
            });

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully. We will contact you soon!',
                'submission_id' => $contactSubmission->id
            ]);

        } catch (\Exception $e) {
            Log::error('Loan application submission failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to submit application. Please try again later.'
            ], 500);
        }
    }
   const STATUS_PENDING = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function index(Request $request)
    {
        $query = ContactSubmission::latest();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Loan type filter
        if ($request->has('loan_type') && $request->loan_type) {
            $query->where('loan_type', $request->loan_type);
        }

        // Date filter
        if ($request->has('date_filter') && $request->date_filter) {
            $dateFilter = $request->date_filter;
            $now = now();
            
            switch($dateFilter) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'week':
                    $query->where('created_at', '>=', $now->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', $now->subMonth());
                    break;
            }
        }

        $perPage = $request->get('per_page', 10);
        $submissions = $query->paginate($perPage);

        // Add status colors for UI
        $submissions->getCollection()->transform(function ($submission) {
            $submission->status_color = match($submission->status) {
                self::STATUS_PENDING => 'pending',
                self::STATUS_IN_REVIEW => 'in_review',
                self::STATUS_APPROVED => 'approved',
                self::STATUS_REJECTED => 'rejected',
                default => 'secondary'
            };
            return $submission;
        });

        // Get counts for status tabs
        $statusCounts = [
            'pending' => ContactSubmission::where('status', self::STATUS_PENDING)->count(),
            'in_review' => ContactSubmission::where('status', self::STATUS_IN_REVIEW)->count(),
            'approved' => ContactSubmission::where('status', self::STATUS_APPROVED)->count(),
            'rejected' => ContactSubmission::where('status', self::STATUS_REJECTED)->count(),
        ];

        $totalCount = ContactSubmission::count();

        return view('backend.contact-submissions.index', compact('submissions', 'statusCounts', 'totalCount'));
    }

    public function show(ContactSubmission $contactSubmission)
    {
        $contactSubmission->status_color = match($contactSubmission->status) {
            self::STATUS_PENDING => 'pending',
            self::STATUS_IN_REVIEW => 'in_review',
            self::STATUS_APPROVED => 'approved',
            self::STATUS_REJECTED => 'rejected',
            default => 'secondary'
        };

        return response()->json($contactSubmission);
    }

    public function updateStatus(Request $request, ContactSubmission $contactSubmission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,approved,rejected'
        ]);

        try {
            $contactSubmission->update(['status' => $validated['status']]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Status update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
}
