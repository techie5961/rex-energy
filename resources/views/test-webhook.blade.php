<!DOCTYPE html>
<html>
<head>
    <title>Test Webhook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .signature-string { 
            background: #f8f9fa; 
            padding: 10px; 
            border-radius: 5px;
            word-break: break-all;
            font-size: 12px;
            border: 1px solid #dee2e6;
        }
        .result-box {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .params-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🧪 NekPay Webhook Tester</h4>
        </div>
        <div class="card-body">
            <!-- Response -->
            <div class="result-box mb-4">
                <h5>📨 Webhook Response</h5>
                <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">{{ $response === 'success' ? '✅ Success' : '❌ ' . $response }}</span></p>
                <p class="mb-0"><strong>Response:</strong> <code>{{ $response }}</code></p>
            </div>
            
            <!-- Signature -->
            <div class="mb-4">
                <h5>🔑 Generated Signature</h5>
                <div class="signature-string">
                    <strong>Signature:</strong> {{ $signature }}
                </div>
            </div>
            
            <!-- Signature String -->
            <div class="mb-4">
                <h5>📝 Signature String</h5>
                <div class="signature-string">
                    {{ $signature }}
                </div>
            </div>
            
            <!-- Data Sent -->
            <div class="mb-4">
                <h5>📤 Data Sent to Webhook</h5>
                <div class="params-box">
                    <pre>{{ json_encode($params, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            
            <!-- Form to send again -->
            <form method="POST" action="{{ url('/nekpay/payment/webhook') }}" class="mt-3">
                @csrf
                <h5>🔄 Send Again</h5>
                <div class="row">
                    @foreach($params as $key => $value)
                        <div class="col-md-6 mb-2">
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            <small><strong>{{ $key }}</strong>: {{ $value }}</small>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Send Webhook Again</button>
                <a href="{{ url('/test-webhook') }}" class="btn btn-secondary">Refresh</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>