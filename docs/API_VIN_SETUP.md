# API.VIN Setup for Saudi Arabia Vehicle Data

## Overview
This application now uses API.VIN service to retrieve vehicle information for Saudi Arabia and global vehicles. API.VIN provides comprehensive vehicle data including make, model, year, engine specifications, and more.

## Setup Instructions

### 1. Register for API.VIN Account
1. Visit [API.VIN](https://api.vin/)
2. Sign up for an account
3. Choose a plan that suits your needs
4. Get your API Key and Secret Key from the dashboard

### 2. Configure Environment Variables
Add the following variables to your `.env` file:

```env
# API.VIN Configuration
API_VIN_KEY=your_api_key_here
API_VIN_SECRET=your_secret_key_here
```

### 3. API.VIN Features
- **Global Coverage**: Supports vehicles from Saudi Arabia and worldwide
- **Comprehensive Data**: Provides detailed vehicle specifications
- **Real-time Lookup**: Instant VIN decoding
- **Multiple Data Points**: Make, model, year, engine, transmission, etc.

### 4. Supported Vehicle Information
The integration retrieves the following data:
- Make/Manufacturer
- Model
- Year
- Body Class/Type
- Engine Model
- Fuel Type
- Drive Type
- Transmission Style
- Vehicle Type
- Number of Doors
- Engine Cylinders
- Engine Displacement
- Gross Vehicle Weight Rating

### 5. Error Handling
The system handles various error scenarios:
- Invalid API credentials
- Rate limit exceeded
- VIN not found in database
- Network timeouts
- Invalid VIN format

### 6. Usage
1. Navigate to `/vehicles/create`
2. Enter a 17-character VIN
3. Click "Lookup Vehicle"
4. Review the retrieved vehicle information
5. Click "Create Vehicle" to save

### 7. API Pricing
API.VIN offers various pricing plans:
- Free tier with limited requests
- Paid plans for higher volume usage
- Check their website for current pricing

### 8. Alternative Services
If API.VIN doesn't meet your needs, consider:
- VINDecoderVehicle.com
- Sweent VIN Decoder SaaS
- NHTSA vPIC API (US vehicles only)

## Support
For API.VIN specific issues, contact their support team through their website.
For application issues, check the Laravel logs in `storage/logs/laravel.log`.
