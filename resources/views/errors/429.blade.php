{{-- resources/views/errors/429.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>
    {{ $exception->getStatusCode() }} | {{ $exception->getMessage() ?: $exception->getStatusText() }}
  </title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased">
  <div class="relative flex items-top justify-center min-h-screen bg-[#1b202d] sm:items-center sm:pt-0">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
      <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
        <div class="px-4 text-lg text-white font-bold border-r border-gray-400 tracking-wider">
          {{ $exception->getStatusCode() }}
        </div>

        <div class="ml-4 text-lg text-white uppercase tracking-wider">
          {{ $exception->getMessage() ?: $exception->getStatusText() }}
        </div>
      </div>
    </div>
  </div>
</body>
</html>
