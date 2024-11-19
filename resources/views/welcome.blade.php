<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>


</head>

<body class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Stripe</h1>
            <div class="row">

                <div class="col-md-6">
                    <a href="{{ route('subcribe') }}" class="btn btn-primary">Subscription</a>
                    <div class="mt-5">

                        @if(!empty($subscription ) )
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            Subscription ID: {{ $subscription->id }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Status:
                                <span class="badge bg-{{ $subscription->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </h5>

                            <p><strong>Customer ID:</strong> {{ $subscription->customer }}</p>

                            <p><strong>Created:</strong> {{ \Carbon\Carbon::createFromTimestamp($subscription->created)->toFormattedDateString() }}</p>

                            <p><strong>Current Period Start:</strong> {{ \Carbon\Carbon::createFromTimestamp($subscription->current_period_start)->toFormattedDateString() }}</p>

                            <p><strong>Current Period End:</strong> {{ \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)->toFormattedDateString() }}</p>

                            <p><strong>Billing Interval:</strong> {{ ucfirst($subscription->items->data[0]->plan->interval) }}</p>

                            <p><strong>Amount:</strong> ${{ number_format($subscription->items->data[0]->price->unit_amount / 100, 2) }} {{ strtoupper($subscription->items->data[0]->price->currency) }}</p>

                            <p><strong>Payment Method:</strong> {{ $subscription->default_payment_method ?? 'Not provided' }}</p>

                            <h3>
                                @if ($subscription->status === 'active' || $subscription->status === 'success')
                                <a href="{{ route('cancel-subcribtion',$subscription->id) }}" class="btn btn-danger">Cancle Subscription</a>
                                @endif

                            </h3>
                        </div>
                    </div>
                @else
                    <p class="text-danger">No subscription details found.</p>
                @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('checkout') }}" class="btn btn-primary">checkout</a>

                    <div class="mt-5">
                        @if ($checkout == 'success')
                        <h1>
                            <span class="badge bg-success">Checkout Successfull</span>

                        </h1>
                        <div>
                            <p>Transaction ID: {{ $transactionId }}</p>

                            <h2>Stripe Checkout Session Object</h2>
                            <pre>{{ print_r($customerDetails, true) }}</pre>
                        </div>
                        @elseif ($checkout == 'fail')
                        <h1>
                            <span class="badge bg-danger">Checkout Failed</span>
                        </h1>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
