<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-gray-50">
    <main>
        {{ $slot }} <!-- Aqui será injetado o conteúdo do componente Livewire -->
    </main>
    
    @livewireScripts
</body>
</html>