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
use App\Livewire\Admin\Podcast\Analytics as PodcastAnalytics;
use App\Livewire\Podcast\Index as PodcastIndex;
use App\Livewire\Podcast\ShowDetail as PodcastShowDetail;
use App\Livewire\Podcast\EpisodePlayer;

// News
use App\Livewire\Page\NewsPage;
use App\Livewire\Page\NewsDetail;
use App\Livewire\Page\ShowPage;
use App\Livewire\Page\ShowDetail;
use App\Livewire\Page\SchedulePage;
use App\Livewire\Page\OapDirectory;
use App\Livewire\Page\OapDetail;
use App\Livewire\Admin\News\NewsForm;
use App\Livewire\Admin\News\Categories as NewsCategories;
use App\Livewire\Admin\News\NewsIndex as AdminNewsIndex;
use App\Livewire\Page\EventPage;
use App\Livewire\Page\EventDetail;
use App\Livewire\Admin\Event\EventIndex as AdminEventIndex;
use App\Livewire\Admin\Event\EventForm as AdminEventForm;
use App\Livewire\Admin\Event\EventCategories as AdminEventCategories;
use App\Livewire\Admin\Event\EventCategoryForm as AdminEventCategoryForm;

use App\Livewire\Admin\Show\Manage as ShowManage;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/shows', ShowPage::class)->name('shows.index');
Route::get('/shows/{slug}', ShowDetail::class)->name('shows.show');
Route::get('/schedule', SchedulePage::class)->name('schedule');
Route::get('/oaps', OapDirectory::class)->name('oaps.index');
Route::get('/oaps/{slug}', OapDetail::class)->name('oaps.show');


// Public Blog Routes - ADD THESE AT THE TOP of public routes section
Route::get('/blog', \App\Livewire\Page\BlogPage::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Livewire\Page\BlogDetail::class)->name('blog.show');

// Public News Routes
Route::get('/news', NewsPage::class)->name('news');
Route::get('/news/{slug}', NewsDetail::class)->name('news.show');

// Public Event Routes
Route::get('/events', EventPage::class)->name('events.index');
Route::get('/events/{slug}', EventDetail::class)->name('events.show');


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
    Route::get('/{slug}/preview', \App\Livewire\Page\BlogDetail::class)->name('preview');
});

// Admin Event Routes
Route::middleware('auth')->prefix('admin/events')->name('admin.events.')->group(function () {
    Route::get('/', AdminEventIndex::class)->name('index');
    Route::get('/create', AdminEventForm::class)->name('create');
    Route::get('/categories', AdminEventCategories::class)->name('categories');
    Route::get('/categories/create', AdminEventCategoryForm::class)->name('categories.create');
    Route::get('/categories/{categoryId}/edit', AdminEventCategoryForm::class)->name('categories.edit');
    Route::get('/{slug}/preview', EventDetail::class)->name('preview');
    Route::get('/{id}/edit', AdminEventForm::class)->name('edit');
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
    Route::get('/admin/podcasts/analytics', PodcastAnalytics::class)->name('admin.podcasts.analytics');
    

    Route::get('/podcasts', PodcastIndex::class)->name('podcasts.index');
    Route::get('/podcasts/{slug}', PodcastShowDetail::class)->name('podcasts.show');
    Route::get('/podcasts/{showSlug}/{episodeSlug}', EpisodePlayer::class)->name('podcasts.episode');

  
    Route::prefix('admin/shows')->name('admin.shows.')->group(function () {
        Route::get('/', ShowManage::class)->name('index');
        Route::get('/oaps', ShowManage::class)->name('oaps')->defaults('view', 'oaps');
        Route::get('/schedule', ShowManage::class)->name('schedule')->defaults('view', 'schedule');
        Route::get('/segments', ShowManage::class)->name('segments')->defaults('view', 'segments');
        Route::get('/categories', ShowManage::class)->name('categories')->defaults('view', 'categories');
    });
    
    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});
