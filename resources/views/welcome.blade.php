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

        <div class="flex my-10 gap-x-20">
            <div class="ml-10 w-[27rem] rounded bg-gray-50 p-8 shadow-md">
                <h1 class="mb-4 text-2xl font-bold">Enviar Archivos</h1>
                @if (session()->exists('success'))
                    <div class="font-semibold text-green-500">
                        Tus archivos se enviaron correctamente.
                    </div>
                @endif
                <form action="/transfers" class="space-y-4" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Enviar email a</label>
                        <input type="text" name="to_email" value="{{ old('to_email') }}" class="mt-1 w-full rounded-md border p-2" />
                        @error('to_email')
                            <div class="text-xs text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Tu email</label>
                        <input type="text" name="from_email" value="{{ old('from_email') }}" class="mt-1 w-full rounded-md border p-2" />
                        @error('from_email')
                            <div class="text-xs text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Título</label>
                        <input name="title" value="{{ old('title') }}" class="mt-1 w-full rounded-md border p-2" />
                        @error('title')
                            <div class="text-xs text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Mensaje</label>
                        <textarea name="message" class="mt-1 w-full rounded-md border p-2">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="text-xs text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700">Archivo</label>
                        <input type="file" id="file" name="file" value="{{ old('file') }}" class="mt-1" multiple />
                        @error('file')
                            <div class="text-xs text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="w-full rounded-md bg-blue-500 p-2 text-white hover:bg-blue-600">Enviar</button>
                </form>
            </div>

            <blockquote class="relative w-[30rem] mt-5">
                <svg class="absolute top-0 left-0 transform -translate-x-6 -translate-y-8 h-16 w-16 text-gray-100 dark:text-gray-700" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7.39762 10.3C7.39762 11.0733 7.14888 11.7 6.6514 12.18C6.15392 12.6333 5.52552 12.86 4.76621 12.86C3.84979 12.86 3.09047 12.5533 2.48825 11.94C1.91222 11.3266 1.62421 10.4467 1.62421 9.29999C1.62421 8.07332 1.96459 6.87332 2.64535 5.69999C3.35231 4.49999 4.33418 3.55332 5.59098 2.85999L6.4943 4.25999C5.81354 4.73999 5.26369 5.27332 4.84476 5.85999C4.45201 6.44666 4.19017 7.12666 4.05926 7.89999C4.29491 7.79332 4.56983 7.73999 4.88403 7.73999C5.61716 7.73999 6.21938 7.97999 6.69067 8.45999C7.16197 8.93999 7.39762 9.55333 7.39762 10.3ZM14.6242 10.3C14.6242 11.0733 14.3755 11.7 13.878 12.18C13.3805 12.6333 12.7521 12.86 11.9928 12.86C11.0764 12.86 10.3171 12.5533 9.71484 11.94C9.13881 11.3266 8.85079 10.4467 8.85079 9.29999C8.85079 8.07332 9.19117 6.87332 9.87194 5.69999C10.5789 4.49999 11.5608 3.55332 12.8176 2.85999L13.7209 4.25999C13.0401 4.73999 12.4903 5.27332 12.0713 5.85999C11.6786 6.44666 11.4168 7.12666 11.2858 7.89999C11.5215 7.79332 11.7964 7.73999 12.1106 7.73999C12.8437 7.73999 13.446 7.97999 13.9173 8.45999C14.3886 8.93999 14.6242 9.55333 14.6242 10.3Z" fill="currentColor"/>
                </svg>

                <div class="relative z-10">
                    <p class="text-gray-800 sm:text-base dark:text-white">
                        <em>{{ $quote['quote'] }}</em>
                    </p>
                </div>

                <footer class="mt-2">
                    <div class="text-base font-semibold text-gray-800 dark:text-gray-400">{{ $quote['author'] }}</div>
                </footer>
            </blockquote>
        </div>


    </body>
</html>
