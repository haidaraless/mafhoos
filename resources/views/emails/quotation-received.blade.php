<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quotation Received</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        
        .email-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        .header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .content {
            padding: 30px;
        }
        
        .quotation-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .quotation-details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #374151;
        }
        
        .detail-value {
            color: #6b7280;
        }
        
        .total-amount {
            background: #3b82f6;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        
        .total-amount .amount {
            font-size: 24px;
            font-weight: 700;
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
        
        .spareparts-list {
            margin: 20px 0;
        }
        
        .sparepart-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            margin: 10px 0;
        }
        
        .sparepart-name {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }
        
        .sparepart-price {
            color: #059669;
            font-weight: 600;
        }
        
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>New Quotation Received</h1>
            <p>You have received a new {{ $quotation->type === \App\Enums\QuotationType::REPAIR ? 'repair' : 'spare parts' }} quotation</p>
        </div>
        
        <div class="content">
            <div class="quotation-badge">✓ New Quotation</div>
            
            <h2>Hello {{ $user->name ?? 'Customer' }},</h2>
            
            <p>Great news! You have received a new {{ $quotation->type === \App\Enums\QuotationType::REPAIR ? 'repair' : 'spare parts' }} quotation for your vehicle. Below are the quotation details:</p>
            
            <div class="quotation-details">
                <h3>Quotation Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Quotation Number:</span>
                    <span class="detail-value">#{{ $quotation->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Vehicle:</span>
                    <span class="detail-value">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">{{ $provider->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Quotation Type:</span>
                    <span class="detail-value">{{ $quotation->type === \App\Enums\QuotationType::REPAIR ? 'Repair Service' : 'Spare Parts' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created Date:</span>
                    <span class="detail-value">{{ $quotation->created_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
            </div>

            @if($quotation->type === \App\Enums\QuotationType::SPARE_PARTS && $quotation->quotationSpareparts->count() > 0)
                <div class="spareparts-list">
                    <h3>Spare Parts Pricing</h3>
                    @foreach($quotation->quotationSpareparts as $quotationSparepart)
                        <div class="sparepart-item">
                            <div class="sparepart-name">{{ $quotationSparepart->damageSparepart->sparepart->name }}</div>
                            <div class="sparepart-price">SAR {{ number_format($quotationSparepart->price, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="total-amount">
                <div>Total Quotation Amount</div>
                <div class="amount">SAR {{ number_format($quotation->total, 2) }}</div>
            </div>
            
            <p>Please review the quotation details and contact the provider if you have any questions or would like to proceed with the service.</p>
            
            <a href="{{ route('dashboard.vehicle-owner') }}" class="cta-button">View in Dashboard</a>
        </div>
        
        <div class="footer">
            <p>This is an automated message from Mafhoos Vehicle Management System.</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html>
