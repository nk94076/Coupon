<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code }} — {{ $title }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #0f172a;
            padding: 1.5rem;
        }
        .card {
            width: 100%;
            max-width: 28rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .code {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 9999px;
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
        }
        h1 { font-size: 1.125rem; font-weight: 600; margin: 0 0 0.5rem; }
        p { color: #64748b; font-size: 0.9rem; line-height: 1.5; margin: 0 0 1.5rem; }
        a.button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 1.25rem;
            background: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }
        a.button:hover { background: #4338ca; }
    </style>
</head>
<body>
    <div class="card">
        <span class="code">{{ $code }}</span>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        <a class="button" href="{{ url('/admin') }}">Go to Admin</a>
    </div>
</body>
</html>
