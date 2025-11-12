<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
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
            background: #3b82f6;
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
        .appointment-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .invoice-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
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
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            padding: 15px 0;
            border-top: 2px solid #3b82f6;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f3f4f6;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Vehicle Inspection Appointment</h1>
        <p>Confirmation & Invoice</p>
    </div>
    
    <div class="content">
        <div class="success-badge">✓ Payment Successful</div>
        
        <h2>Hello {{ $appointment->vehicle->user->name ?? 'Customer' }},</h2>
        
        <p>Your vehicle inspection appointment has been confirmed and payment processed successfully. Below are your appointment and invoice details:</p>
        
        <div class="appointment-details">
            <h3>Appointment Details</h3>
            <div class="detail-row">
                <span class="detail-label">Appointment Number:</span>
                <span class="detail-value">{{ $appointment->number }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Inspection Type:</span>
                <span class="detail-value">{{ str_replace('-', ' ', $appointment->inspection_type->value ?? $appointment->inspection_type) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Provider:</span>
                <span class="detail-value">{{ $appointment->provider->name ?? 'Not selected' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date & Time:</span>
                <span class="detail-value">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y \a\t g:i A') : 'Not scheduled' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Vehicle:</span>
                <span class="detail-value">{{ $appointment->vehicle->year }} {{ $appointment->vehicle->make }} {{ $appointment->vehicle->model }}</span>
            </div>
        </div>
        
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <div class="detail-row">
                <span class="detail-label">Payment ID:</span>
                <span class="detail-value">{{ $fee->payment_id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucfirst($fee->payment_method) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <span class="detail-value">{{ $fee->paid_at->format('M d, Y \a\t g:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Description:</span>
                <span class="detail-value">{{ $fee->description }}</span>
            </div>
            <div class="total-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value">SAR {{ number_format($inspectionPrice, 2) }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Thank you for choosing our vehicle inspection service!</strong></p>
            <p>If you have any questions, please contact our support team.</p>
            <p style="color: #6b7280; font-size: 14px;">
                This is an automated confirmation email. Please keep this for your records.
            </p>
        </div>
    </div>
</body>
</html>
