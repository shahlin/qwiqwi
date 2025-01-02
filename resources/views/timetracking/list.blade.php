<html>
    <head>
        <title>List of Trackers</title>
        <!-- Add Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .tracker-card {
                transition: transform 0.2s;
            }
            .tracker-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .tracker-value {
                font-size: 2.5rem;
                font-weight: bold;
            }
            .last-updated {
                color: #6c757d;
                font-size: 0.875rem;
            }
        </style>
    </head>

    <body>
        <div class="container py-5">
            <h1 class="mb-4">Trackers</h1>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($trackers as $type => $tracker)
                    <div class="col">
                        <div class="card h-100 tracker-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $type }}</h5>
                                <div class="tracker-value my-3">
                                    @if ($tracker['minutes'] >= 60)
                                        {{ round($tracker['minutes'] / 60, 2) }} <small class="text-muted" style="font-size: 1rem;">{{ $tracker['minutes'] / 60 == 1 ? 'hour' : 'hours' }}</small>
                                    @else
                                        {{ $tracker['minutes'] }} <small class="text-muted" style="font-size: 1rem;">{{ $tracker['minutes'] == 1 ? 'minute' : 'minutes' }}</small>
                                    @endif
                                </div>
                                <div class="last-updated">
                                    Updated {{ $tracker['last_updated'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    </body>
</html>