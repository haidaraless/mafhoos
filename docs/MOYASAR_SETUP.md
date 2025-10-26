# Moyasar Payment Gateway Setup

This document explains how to set up Moyasar payment gateway for the PayFees component.

## Environment Variables

Add the following environment variables to your `.env` file:

```env
# Moyasar Payment Gateway
MOYASAR_SECRET_KEY=your_moyasar_secret_key_here
MOYASAR_PUBLISHABLE_KEY=your_moyasar_publishable_key_here
MOYASAR_WEBHOOK_SECRET=your_moyasar_webhook_secret_here
```

## Getting Moyasar Credentials

1. Sign up for a Moyasar account at [https://moyasar.com](https://moyasar.com)
2. Navigate to your dashboard
3. Go to API Keys section
4. Copy your Secret Key and Publishable Key
5. Set up webhooks if needed for payment callbacks

## Inspection Pricing

The system includes fixed pricing for different inspection types:

- **Undercarriage Inspection**: SAR 150.00
- **Engine Inspection**: SAR 200.00  
- **Comprehensive Inspection**: SAR 300.00

## Payment Flow

1. User completes appointment scheduling (inspection center, type, and date)
2. User clicks "Complete Appointment" button in appointment-progress
3. User is redirected to PayFees component
4. User enters payment details and processes payment
5. Payment is processed through Moyasar
6. Fee record is created in the database
7. User is redirected to success page

## Testing

For testing purposes, you can use Moyasar's test mode with test card numbers:

- **Test Card Number**: 4111111111111111
- **CVV**: Any 3-digit number
- **Expiry**: Any future date

## Security Notes

- All payment data is handled securely by Moyasar
- Card details are not stored in the application
- Payment processing is PCI DSS compliant through Moyasar
