<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="mx-auto my-20 w-[27rem] rounded bg-gray-50 p-8 shadow-md">
            <h1 class="mb-4 text-2xl font-bold">Enviar Archivos</h1>
            <form action="#" class="space-y-4">
                <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Enviar email a</label>
                <input type="text" name="to_email" class="mt-1 w-full rounded-md border p-2" />
                </div>
                <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Tu email</label>
                <input type="text" name="from_email" class="mt-1 w-full rounded-md border p-2" />
                </div>
                <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Título</label>
                <input name="title" class="mt-1 w-full rounded-md border p-2" />
                </div>
                <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Mensaje</label>
                <textarea name="message" class="mt-1 w-full rounded-md border p-2"></textarea>
                </div>
                <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Archivo</label>
                <input type="file" id="file" name="file" class="mt-1" multiple />
                </div>
                <button type="submit" class="w-full rounded-md bg-blue-500 p-2 text-white hover:bg-blue-600">Enviar</button>
            </form>
        </div>
    </body>
</html>
