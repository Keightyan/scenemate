<?php

namespace App\Http\Controllers;

use App\Mail\ReportReceived;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'reported_user_id' => ['required', 'exists:users,id'],
            'reason' => ['required', 'string', 'max:255'],
            'detail' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($request->user()->id === (int) $request->reported_user_id) {
            return back()->withErrors(['reported_user_id' => '自分を通報することはできません。']);
        }

        $report = Report::create([
            'reporter_user_id' => $request->user()->id,
            'reported_user_id' => $request->reported_user_id,
            'reason' => $request->reason,
            'detail' => $request->detail,
        ]);

        $adminEmail = config('app.admin_email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ReportReceived($report));
        }

        return back()->with('success', '通報を受け付けました。');
    }
}
