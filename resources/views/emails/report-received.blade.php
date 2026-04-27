<x-mail::message>
# ユーザー通報が届きました

**通報日時:** {{ $report->created_at->format('Y年m月d日 H:i') }}

**通報者ID:** {{ $report->reporter_user_id }}

**通報対象ユーザーID:** {{ $report->reported_user_id }}

**理由:** {{ $report->reason }}

@if($report->detail)
**詳細:**
{{ $report->detail }}
@endif

</x-mail::message>
