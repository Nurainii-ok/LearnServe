# Midtrans Payment Gateway Integration

This guide explains how to use the implemented Midtrans payment gateway in your LearnServe project.

## 🚀 Setup Instructions

### 1. Get Midtrans Account
1. Sign up at [Midtrans Dashboard](https://dashboard.sandbox.midtrans.com/)
2. Create a new merchant account
3. Get your Server Key and Client Key from Settings > Access Keys

### 2. Configure Environment Variables
Update your `.env` file with your Midtrans credentials:

```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY_HERE
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY_HERE
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**Note:** Replace `YOUR_SERVER_KEY_HERE` and `YOUR_CLIENT_KEY_HERE` with your actual keys from Midtrans Dashboard.

### 3. Test the Integration
1. Go to `/checkout` page
2. Fill in customer information
3. Click "Pay" button
4. Use Midtrans test cards for testing

## 💳 Test Credit Card Numbers

For testing purposes, use these credit card numbers:

| Card Type | Number | CVV | Exp Date | Result |
|-----------|--------|-----|----------|--------|
| Visa | 4811 1111 1111 1114 | 123 | 01/25 | Success |
| Mastercard | 5573 3811 1111 1113 | 123 | 01/25 | Success |
| JCB | 3528 2033 2456 4357 | 123 | 01/25 | Success |
| AMEX | 3701 7119 9949 5904 | 1234 | 01/25 | Success |

## 🔄 Payment Flow

1. **Customer fills checkout form** → Customer information is collected
2. **Payment creation** → Creates payment record in database
3. **Midtrans Snap** → Opens payment popup with various payment methods
4. **Payment processing** → Customer completes payment
5. **Notification** → Midtrans sends webhook notification
6. **Status update** → Payment status is updated in database
7. **Redirect** → Customer is redirected to success/failure page

## 📱 Available Payment Methods

Midtrans supports various payment methods:
- **Credit/Debit Cards:** Visa, Mastercard, JCB, AMEX
- **Bank Transfer:** BCA, BNI, BRI, Mandiri, Permata
- **E-wallets:** GoPay, OVO, DANA, LinkAja
- **Retail:** Alfamart, Indomaret
- **Others:** Kredivo, Akulaku

## 🛠 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/payment/create-transaction` | Create payment transaction |
| POST | `/payment/notification` | Handle Midtrans webhook |
| GET | `/payment/finish` | Payment finish redirect |
| GET | `/payment/success` | Payment success page |
| GET | `/payment/failed` | Payment failure page |
| GET | `/payment/status/{orderId}` | Check payment status |

## 🔧 Key Features Implemented

✅ **Secure Payment Processing** - All payments processed through Midtrans
✅ **Multiple Payment Methods** - Cards, bank transfer, e-wallets, retail
✅ **Real-time Notifications** - Webhook integration for instant status updates
✅ **Customer Information** - Collects and stores customer details
✅ **Order Management** - Tracks payments with unique order IDs
✅ **Error Handling** - Graceful error handling and user feedback
✅ **Mobile Responsive** - Works on all devices
✅ **Test Mode Support** - Easy testing with sandbox environment

## 🚨 Production Setup

When ready for production:

1. Change `MIDTRANS_IS_PRODUCTION=true` in `.env`
2. Update Server Key and Client Key with production credentials
3. Update Snap JS URL to production:
   ```html
   <script src="https://app.midtrans.com/snap/snap.js"></script>
   ```
4. Configure webhook URL in Midtrans Dashboard:
   ```
   https://yourdomain.com/payment/notification
   ```

## 📝 Database Tables

### Payments Table Fields:
- `user_id` - User who made the payment
- `class_id` - Course being purchased
- `full_name` - Customer name
- `email` - Customer email
- `phone` - Customer phone
- `whatsapp` - Customer WhatsApp (optional)
- `amount` - Payment amount
- `payment_method` - Always 'midtrans'
- `payment_type` - Specific payment type from Midtrans
- `transaction_id` - Unique order ID
- `snap_token` - Midtrans Snap token
- `midtrans_response` - JSON response from Midtrans
- `status` - Payment status (pending, completed, failed, refunded)
- `payment_date` - When payment was completed
- `midtrans_paid_at` - Timestamp from Midtrans
- `notes` - Additional notes

## 🔍 Troubleshooting

### Common Issues:

1. **Invalid Server Key/Client Key**
   - Check your credentials in Midtrans Dashboard
   - Ensure you're using the correct environment (sandbox/production)

2. **Webhook not working**
   - Check if webhook URL is accessible
   - Verify webhook URL in Midtrans Dashboard
   - Check Laravel logs for errors

3. **Payment not updating**
   - Check notification logs
   - Verify webhook endpoint is working
   - Check database for payment records

### Debug Mode:
Check Laravel logs at `storage/logs/laravel.log` for detailed error information.

## 📞 Support

For issues with this integration:
1. Check Laravel logs
2. Check Midtrans Dashboard logs
3. Review this documentation
4. Contact Midtrans support for payment gateway issues