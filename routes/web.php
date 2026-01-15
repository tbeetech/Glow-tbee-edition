<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Page\HomePage;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use App\Livewire\Page\AboutPage;
use App\Livewire\Page\ContactPage;

// Podcast Routes
use App\Livewire\Admin\Podcast\Manage as PodcastManage;
use App\Livewire\Podcast\Index as PodcastIndex;
use App\Livewire\Podcast\ShowDetail as PodcastShowDetail;
use App\Livewire\Podcast\EpisodePlayer;

// News
use App\Livewire\Page\NewsPage;
use App\Livewire\Page\NewsDetail;
use App\Livewire\Admin\News\NewsForm;
use App\Livewire\Admin\News\Categories as NewsCategories;
use App\Livewire\Admin\News\NewsIndex as AdminNewsIndex;

use App\Livewire\Admin\Show\Manage as ShowManage;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');


// Public Blog Routes - ADD THESE AT THE TOP of public routes section
Route::get('/blog', \App\Livewire\Page\BlogPage::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Livewire\Page\BlogDetail::class)->name('blog.show');

// Public News Routes
Route::get('/news', NewsPage::class)->name('news');
Route::get('/news/{slug}', NewsDetail::class)->name('news.show');
// Public News Routes
Route::get('/news', NewsPage::class)->name('news');
Route::get('/news/{slug}', NewsDetail::class)->name('news.show');


// Guest Routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});


// Admin Blog Routes
Route::middleware('auth')->prefix('admin/blog')->name('admin.blog.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Blog\BlogIndex::class)->name('index');
    Route::get('/create', \App\Livewire\Admin\Blog\BlogForm::class)->name('create');
    Route::get('/{id}/edit', \App\Livewire\Admin\Blog\BlogForm::class)->name('edit');
    Route::get('/categories', \App\Livewire\Admin\Blog\BlogCategories::class)->name('categories');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Admin News Routes
    Route::prefix('admin/news')->name('admin.news.')->group(function () {
        Route::get('/', AdminNewsIndex::class)->name('index');
        Route::get('/create', NewsForm::class)->name('create');
        Route::get('/{id}/edit', NewsForm::class)->name('edit');
        Route::get('/categories', NewsCategories::class)->name('categories');
    });


 
    Route::get('/admin/podcasts', PodcastManage::class)->name('admin.podcasts.manage');
    

    Route::get('/podcasts', PodcastIndex::class)->name('podcasts.index');
    Route::get('/podcasts/{slug}', PodcastShowDetail::class)->name('podcasts.show');
    Route::get('/podcasts/{showSlug}/{episodeSlug}', EpisodePlayer::class)->name('podcasts.episode');

  
    Route::get('/admin/shows', ShowManage::class)->name('admin.shows.manage');
    
    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});