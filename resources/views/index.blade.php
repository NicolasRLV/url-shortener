<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .response-box {
            transition: all 0.3s ease;
        }
        .response-box.hidden {
            opacity: 0;
            height: 0;
            margin-top: 0;
        }
        .response-box.visible {
            opacity: 1;
            height: auto;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">URL Shortener</h1>

        <!-- Encode Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Shorten a URL</h2>
            <div class="flex space-x-4">
                <input type="text" id="longUrl" 
                       class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="https://www.example.com/very/long/url">
                <button onclick="encodeUrl()" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Shorten
                </button>
            </div>
            <div id="encodeResult" class="response-box hidden mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <p id="encodeText" class="text-gray-800"></p>
            </div>
        </div>

        <!-- Decode Section -->
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Decode a Short URL</h2>
            <div class="flex space-x-4">
                <input type="text" id="shortUrl" 
                       class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="http://localhost:8000/XYZ123">
                <button onclick="decodeUrl()" 
                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Decode
                </button>
            </div>
            <div id="decodeResult" class="response-box hidden mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <p id="decodeText" class="text-gray-800"></p>
            </div>
        </div>
    </div>

    <script>
        async function encodeUrl() {
            const longUrl = document.getElementById('longUrl').value;
            const resultDiv = document.getElementById('encodeResult');
            const resultText = document.getElementById('encodeText');
            resultDiv.classList.remove('visible');
            resultDiv.classList.add('hidden');

            try {
                const response = await fetch('/api/encode', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ url: longUrl })
                });
                const data = await response.json();

                if (response.ok) {
                    resultText.innerHTML = `Short URL: <a href="${data.short_url}" target="_blank" class="text-blue-600 hover:underline">${data.short_url}</a>`;
                } else {
                    resultText.innerHTML = `<span class="text-red-600">Error: ${data.message || 'Invalid URL'}</span>`;
                }
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('visible');
            } catch (error) {
                resultText.innerHTML = `<span class="text-red-600">Error: ${error.message}</span>`;
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('visible');
            }
        }

        async function decodeUrl() {
            const shortUrl = document.getElementById('shortUrl').value;
            const resultDiv = document.getElementById('decodeResult');
            const resultText = document.getElementById('decodeText');
            resultDiv.classList.remove('visible');
            resultDiv.classList.add('hidden');

            try {
                const response = await fetch('/api/decode', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ short_url: shortUrl })
                });
                const data = await response.json();

                if (response.ok) {
                    resultText.innerHTML = `Original URL: <a href="${data.original_url}" target="_blank" class="text-blue-600 hover:underline">${data.original_url}</a>`;
                } else {
                    resultText.innerHTML = `<span class="text-red-600">Error: ${data.error || 'Invalid short URL'}</span>`;
                }
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('visible');
            } catch (error) {
                resultText.innerHTML = `<span class="text-red-600">Error: ${error.message}</span>`;
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('visible');
            }
        }
    </script>
</body>
</html>
