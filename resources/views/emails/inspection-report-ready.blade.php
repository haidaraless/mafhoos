<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Report Ready</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #10b981;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8fafc;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .success-badge {
            background: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .inspection-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
        }
        .damage-summary {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }
        .detail-value {
            font-weight: 500;
            color: #111827;
        }
        .priority-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        .priority-high {
            background: #fef2f2;
            color: #dc2626;
        }
        .priority-medium {
            background: #fffbeb;
            color: #d97706;
        }
        .priority-low {
            background: #f0fdf4;
            color: #16a34a;
        }
        .cta-button {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f3f4f6;
            border-radius: 8px;
        }
        .report-preview {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
            font-style: italic;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Vehicle Inspection Report Ready</h1>
        <p>Your inspection has been completed</p>
    </div>
    
    <div class="content">
        <div class="success-badge">✓ Report Complete</div>
        
        <h2>Hello {{ $user->name ?? 'Customer' }},</h2>
        
        <p>Great news! Your vehicle inspection has been completed and the detailed report is now ready for review. Below are the inspection details and summary of findings:</p>
        
        <div class="inspection-details">
            <h3>Inspection Details</h3>
            <div class="detail-row">
                <span class="detail-label">Inspection Number:</span>
                <span class="detail-value">{{ $inspection->number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Vehicle:</span>
                <span class="detail-value">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Inspection Type:</span>
                <span class="detail-value">{{ str_replace('-', ' ', $appointment->inspection_type->value ?? $appointment->inspection_type) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Provider:</span>
                <span class="detail-value">{{ $appointment->provider->name ?? 'Not specified' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Completed Date:</span>
                <span class="detail-value">{{ $inspection->completed_at ? $inspection->completed_at->format('M d, Y \a\t g:i A') : 'Not specified' }}</span>
            </div>
        </div>

        @if($inspection->damageSpareparts && count($inspection->damageSpareparts) > 0)
            <div class="damage-summary">
                <h3>Damage Summary</h3>
                <p><strong>{{ count($inspection->damageSpareparts) }} damaged sparepart(s) identified:</strong></p>
                
                @php
                    $priorityCounts = [
                        'high' => 0,
                        'medium' => 0,
                        'low' => 0
                    ];
                    foreach($inspection->damageSpareparts as $damageSparepart) {
                        $priority = $damageSparepart->priority->value;
                        $priorityCounts[$priority] = ($priorityCounts[$priority] ?? 0) + 1;
                    }
                @endphp
                
                <div style="margin: 15px 0;">
                    @if($priorityCounts['high'] > 0)
                        <span class="priority-badge priority-high">{{ $priorityCounts['high'] }} High Priority</span>
                    @endif
                    @if($priorityCounts['medium'] > 0)
                        <span class="priority-badge priority-medium">{{ $priorityCounts['medium'] }} Medium Priority</span>
                    @endif
                    @if($priorityCounts['low'] > 0)
                        <span class="priority-badge priority-low">{{ $priorityCounts['low'] }} Low Priority</span>
                    @endif
                </div>

                <div style="margin-top: 15px;">
                    <strong>Damaged Parts:</strong>
                    <ul style="margin: 10px 0; padding-left: 20px;">
                        @foreach($inspection->damageSpareparts as $damageSparepart)
                            <li style="margin: 5px 0;">
                                {{ $damageSparepart->sparepart->name }}
                                <span class="priority-badge priority-{{ $damageSparepart->priority->value }}">
                                    {{ ucfirst($damageSparepart->priority->value) }} Priority
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="damage-summary">
                <h3>Damage Summary</h3>
                <p style="color: #16a34a; font-weight: 600;">✓ No damaged spareparts identified during inspection</p>
            </div>
        @endif

        @if($inspection->report)
            <div class="report-preview">
                <h4>Report Preview:</h4>
                <p>{{ Str::limit($inspection->report, 200) }}</p>
            </div>
        @endif
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('dashboard.vehicle-inspection-center') }}" class="cta-button">
                View Full Report
            </a>
        </div>
        
        <div class="footer">
            <p><strong>Thank you for using our vehicle inspection service!</strong></p>
            <p>If you have any questions about your inspection report, please contact our support team.</p>
            <p style="color: #6b7280; font-size: 14px;">
                This is an automated notification. Please keep this email for your records.
            </p>
        </div>
    </div>
</body>
</html>
