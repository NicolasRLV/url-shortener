# URL Shortener Service

## Assignment Details

### Objective
The goal of this assignment is to implement a URL shortening service.

### Brief
Create a URL shortening service that takes a long URL, such as `https://www.thisisalongdomain.com/with/some/parameters?and=here_too`, and returns a shortened URL, like `http://short.est/GeAi9K`. The service should allow encoding a URL into a short URL and decoding a short URL back to its original URL.

### Tasks
1. Implement two API endpoints:
   - `/encode`: Encodes a long URL into a shortened URL.
   - `/decode`: Decodes a shortened URL back to its original URL.
2. Both endpoints must return JSON responses.
3. The encode/decode algorithm can be designed freely, as long as a URL can be encoded to a short URL and decoded back to the original URL.
4. Short URLs do not need to be persisted; in-memory storage is sufficient.
5. Provide detailed instructions on how to run the application in a `README.md` file.
6. Cover all functionality with tests.

## Requirements
- PHP 8.3.15
- Laravel 5.14.2
- Composer 2.8.4

## Setup Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/NicolasRLV/url-shortener.git
   cd url-shortener

2. Install dependencies:
   ```bash
   composer install

3. Copy the environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate

4. Start the development server:
   ```bash
   php artisan serve
   
# API Endpoints

## Encode URL
Endpoint: POST /api/encode
Payload: 
   {
      "url": "https://www.example.com/very/long/url/with/parameters"
   }
response:
   {
      "short_url": "http://localhost:8000/XYZ123"
   }

## Decode URL
Endpoint: POST /api/decode
Payload: 
   {
      "short_url": "http://localhost:8000/XYZ123"
   }
response:
   {
      "original_url": "https://www.example.com/very/long/url/with/parameters"
   }

# Frontend Interface

## A polished web interface is provided at the root URL (/) for easy testing:
   URL: http://localhost:8000/ (when running php artisan serve)
   Features:
      Encode: Enter a long URL to generate a shortened URL, displayed in a clean, clickable format.
      Decode: Enter a short URL to retrieve the original URL, presented as a clickable link.
   Design: Built with Tailwind CSS for a modern, professional look, featuring distinct sections, styled inputs, and animated response boxes.
   Usage: Open the URL in a browser after starting the server, input URLs, and click the buttons to see results.

# Running Tests
## To verify the functionality, run the test suite:
   php artisan test

## Implementation Details
   Storage: Uses Laravel’s file cache driver to store URL mappings in memory during a server session, fulfilling the in-memory requirement while persisting across requests for practical testing. Data is stored in storage/framework/cache/data and resets when the server stops.
   Short Code Generation: Generates 6-character random codes using alphanumeric characters (a-z, A-Z, 0-9).
   Validation: Includes input validation to ensure valid URLs are provided (required|url rule).
   Response Format: All endpoints return JSON responses as specified.
   Frontend: A Blade template (index.blade.php) with Tailwind CSS and JavaScript provides a user-friendly, professional interface to test the API endpoints directly in the browser.
   Testing: Comprehensive tests cover:
      Successful encoding and decoding.
      Validation failure for invalid URLs (returns 422).
      404 response for invalid short URLs.
