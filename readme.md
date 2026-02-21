# Movie App Technical Test (Laravel 5.8)

A modern movie search application built with Laravel 5.8, integrating with the OMDb API.

## 🚀 Features
- **Cinematic Authentication**: Hardcoded login (`aldmic` / `123abc123`) with glassmorphism UI and error feedback.
- **Advanced Movie Search**: Filter by Title, Type (Movie/Series/Episode), and Year.
- **Infinite Scroll**: Seamlessly load more results using the modern `IntersectionObserver` API.
- **Lazy Loading**: Image performance optimization for posters.
- **Immersive Details**: Hero layout with comprehensive metadata (Cast, Released, Production, Ratings).
- **Personal Collection**: AJAX-powered favorites system (Add/Remove from any screen).
- **Full Multi-Language (EN/ID)**: Complete localization coverage.

## 🛠️ Tech Stack
- **Backend**: Laravel 5.8 (PHP 8.1 Patched)
- **Database**: MySQL (XAMPP)
- **Frontend**: Bootstrap 4.3, Font Awesome 5, Vanilla JavaScript.
- **API**: OMDb API (GuzzleHTTP)

## 📦 Installation
1. Clone the project to `C:\xampp\htdocs\TechnicalTest`.
2. Configure `.env` with your database and `OMDB_API_KEY`.
3. Update `APP_URL` in `.env` to `http://localhost/TechnicalTest/public`.
4. Run: `php artisan migrate --seed`.
5. Run: `php artisan serve`.
6. Login with `aldmic` / `123abc123`.

## 🌐 Deployment
For instructions on how to upload this application to a live server (like 000webhost or CPanel), please refer to the **[Deployment Guide](deploy.md)**.

## Architecture & Technical Details

### 🏗️ Architecture
The application follows the **MVC (Model-View-Controller)** pattern standard to Laravel, with additional layers for better separation of concerns:

- **Service Layer**: The `OmdbService` handles all communication with the OMDb API, abstracting the Guzzle HTTP requests and providing a clean interface for the controllers.
- **Middleware Layer**: 
    - `LocaleMiddleware`: Manages the multi-language system by setting the application locale based on the user's session.
    - `Authenticate`: Ensures that only logged-in users can access the movie database.
- **Frontend Layer**: 
    - Uses **Vanilla JavaScript** (ES6+) for dynamic behaviors like infinite scroll and AJAX favorite toggling to keep the bundle size small and performance high.
    - **Intersection Observer API** is used for efficient scroll detection.
- **Database**: MySQL is used to store user profiles and the `favorites` table, which caches movie metadata (ID, title, year, poster) to allow high-speed rendering of the favorites list.

### 📚 Libraries Used
- **Laravel 5.8**: Core PHP framework (Patched for PHP 8.1 compatibility).
- **GuzzleHTTP**: The industry-standard HTTP client for making reliable API calls.
- **Bootstrap 4.3**: Used for the responsive grid system and base components.
- **Font Awesome 5.15**: Comprehensive icon library for UI elements.
- **Google Fonts (Outfit)**: Premium typography for a modern aesthetic.
- **Intersection Observer**: Modern browser API for infinite scroll and lazy loading.

## Screenshots

### 1. Cinematic Login Page
![Login Page](https://via.placeholder.com/1200x800/141414/ffffff?text=Cinematic+Login+Page+with+Glassmorphism)
*Features a dark, atmospheric background with glassmorphism effects.*

### 2. Movie Grid (Infinite Scroll)
![Movie List](https://via.placeholder.com/1200x800/141414/ffffff?text=Premium+Movie+Grid+Layout)
*Streaming-platform style layout with hover effects and integrated search filters.*

### 3. Cinematic Detail Page
![Movie Detail](https://via.placeholder.com/1200x800/141414/ffffff?text=Cinematic+Movie+Detail+Hero)
*Hero section with backdrop blur and comprehensive movie metadata.*

### 4. Favorites Collection
![Favorites](https://via.placeholder.com/1200x800/141414/ffffff?text=Favorites+Management)
*Easy management of your personally curated movie list.*

## Final Checklist
- [x] PHP 8.1 Compatibility Patches
- [x] OMDb API Integration (Search + Detail)
- [x] Infinite Scroll Implementation
- [x] Lazy Loading for Images
- [x] Multi-Language Support (EN/ID)
- [x] Security (Auth Middleware)
- [x] AJAX Favorites Management
