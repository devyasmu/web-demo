@extends('layouts.public')

@section('title', $siteSettings->site_name ?? 'Yayasan Pendidikan Islam')
@section('description', $siteSettings->site_description ?? 'Yayasan Pendidikan Islam yang berkomitmen untuk memberikan pendidikan berkualitas dengan nilai-nilai Islam yang kuat.')

@section('content')
@php
    $programList = $featuredPrograms instanceof \Illuminate\Contracts\Pagination\Paginator ? $featuredPrograms->getCollection() : collect($featuredPrograms ?? []);
    $postList = $featuredPosts instanceof \Illuminate\Contracts\Pagination\Paginator ? $featuredPosts->getCollection() : collect($featuredPosts ?? []);
    $announcementList = $announcements instanceof \Illuminate\Contracts\Pagination\Paginator ? $announcements->getCollection() : collect($announcements ?? []);
    $testimonialList = $testimonials instanceof \Illuminate\Contracts\Pagination\Paginator ? $testimonials->getCollection() : collect($testimonials ?? []);
    $featureList = collect($features ?? []);
    $statisticList = collect($statistics ?? []);
    $quickLinkList = collect($quickLinks ?? []);
    $institutionContactList = collect($institutionContacts ?? []);

    $siteName = $siteSettings->site_name ?? 'YASMU Manyar';
    $siteDescription = $siteSettings->site_description ?? 'Yayasan pendidikan Islam di Manyar Gresik yang membina generasi beradab, berilmu, dan siap tumbuh.';
    $siteTagline = $siteSettings->site_tagline ?? null;
    $sliderList = collect($sliders ?? [])->take(4)->values();
    $defaultHeroHeadline = $siteTagline ?: 'Generasi beradab, siap tumbuh.';
    $defaultHeroImage = null;

    if (optional($postList->first())->featured_image) {
        $defaultHeroImage = asset('storage/' . $postList->first()->featured_image);
    }

    if (!$defaultHeroImage && optional($programList->first())->featured_image) {
        $defaultHeroImage = asset('storage/' . $programList->first()->featured_image);
    }

    $heroSlides = $sliderList->map(fn ($slider) => [
        'headline' => $slider->title ?: $defaultHeroHeadline,
        'description' => $slider->description ?: $siteDescription,
        'buttonText' => $slider->button_text ?: 'Jelajahi Program',
        'buttonLink' => $slider->button_link ?: route('programs.index'),
        'image' => $slider->image ? asset('storage/' . $slider->image) : $defaultHeroImage,
    ]);

    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([[
            'headline' => $defaultHeroHeadline,
            'description' => $siteDescription,
            'buttonText' => 'Jelajahi Program',
            'buttonLink' => route('programs.index'),
            'image' => $defaultHeroImage,
        ]]);
    }

    $activeHeroSlide = $heroSlides->first();
    $heroHeadline = $activeHeroSlide['headline'];
    $heroDescription = $activeHeroSlide['description'];
    $primaryActionText = $activeHeroSlide['buttonText'];
    $primaryActionLink = $activeHeroSlide['buttonLink'];
    $heroImage = $activeHeroSlide['image'];

    $quickLinksResolved = $quickLinkList->count() > 0
        ? $quickLinkList->take(5)->map(fn ($link) => [
            'title' => $link->title,
            'url' => $link->url,
            'icon' => $link->icon ?: 'bi bi-link-45deg',
            'external' => true,
        ])
        : collect([
            ['title' => 'Program', 'url' => route('programs.index'), 'icon' => 'bi bi-journal-richtext', 'external' => false],
            ['title' => 'Pengumuman', 'url' => route('announcements.index'), 'icon' => 'bi bi-megaphone', 'external' => false],
            ['title' => 'Galeri', 'url' => route('galleries.index'), 'icon' => 'bi bi-images', 'external' => false],
            ['title' => 'Download', 'url' => route('downloads.index'), 'icon' => 'bi bi-download', 'external' => false],
            ['title' => 'Kontak', 'url' => route('contacts.index'), 'icon' => 'bi bi-chat-dots', 'external' => false],
        ]);

    $institutionContactsResolved = $institutionContactList->count() > 0
        ? $institutionContactList
        : collect([
            (object) ['name' => 'Yayasan', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi umum dan kemitraan', 'icon' => 'bi bi-whatsapp'],
            (object) ['name' => 'MTs', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi jenjang madrasah tsanawiyah', 'icon' => 'bi bi-whatsapp'],
            (object) ['name' => 'SMP', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi jenjang sekolah menengah pertama', 'icon' => 'bi bi-whatsapp'],
            (object) ['name' => 'MA', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi jenjang madrasah aliyah', 'icon' => 'bi bi-whatsapp'],
            (object) ['name' => 'SMA', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi jenjang sekolah menengah atas', 'icon' => 'bi bi-whatsapp'],
            (object) ['name' => 'SMK', 'contact_person' => null, 'phone' => $siteSettings->phone ?? null, 'description' => 'Informasi jenjang sekolah menengah kejuruan', 'icon' => 'bi bi-whatsapp'],
        ]);

    $whatsappUrl = \App\Helpers\ContactHelper::whatsappUrl($siteSettings->phone ?? null, 'Halo, saya ingin bertanya tentang program pendidikan YASMU Manyar.');
    $programCount = $programList->count();
    $postCount = $postList->count();
    $testimonialCount = $testimonialList->count();
    $serviceCount = $quickLinksResolved->count();
@endphp

@if(isset($error))
<div class="home-wrap py-3">
    <div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ $error }}
    </div>
</div>
@endif

<section class="home-hero" data-home-hero>
    <div class="home-hero-media">
        <img data-hero-image src="{{ $heroImage }}" alt="{{ $heroHeadline }}" @unless($heroImage) hidden @endunless>
    </div>
    <div class="home-wrap">
        <div class="home-hero-grid">
            <div class="home-hero-copy">
                <div class="home-kicker"><i class="bi bi-stars"></i> Pendidikan Islam Manyar Gresik</div>
                <h1 data-hero-headline>{{ $heroHeadline }}</h1>
                <p data-hero-description>{{ $heroDescription }}</p>
                <div class="home-actions">
                    <a class="home-btn home-btn-gold" href="{{ $primaryActionLink }}" data-hero-primary>
                        <span data-hero-button-text>{{ $primaryActionText }}</span>
                        <i class="bi bi-arrow-up-right"></i>
                    </a>
                    <a class="home-btn home-btn-glass" href="{{ route('galleries.index') }}">
                        <i class="bi bi-play-circle"></i>
                        <span>Lihat Kegiatan</span>
                    </a>
                </div>
            </div>
            <aside class="home-live-card">
                <div class="home-live-head">
                    <div>
                        <span>YASMU Pulse</span>
                        <strong>Aktif hari ini</strong>
                    </div>
                    <span class="home-live-dot"></span>
                </div>
                <div class="home-live-grid">
                    <div><b>{{ $programCount }}</b><span>Program</span></div>
                    <div><b>{{ $postCount }}</b><span>Berita</span></div>
                    <div><b>{{ $testimonialCount }}</b><span>Testimoni</span></div>
                    <div><b>{{ $serviceCount }}</b><span>Akses</span></div>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="home-quick">
    <div class="home-wrap">
        <div class="home-quick-grid">
            @foreach($quickLinksResolved as $link)
            <a href="{{ $link['url'] }}" @if($link['external']) target="_blank" rel="noopener noreferrer" @endif>
                <i class="{{ $link['icon'] }}"></i>
                <span>{{ $link['title'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="home-section home-story">
    <div class="home-wrap home-story-grid">
        <div>
            <div class="home-section-label">Fokus Pendidikan</div>
            <h2>Rapi secara sistem, hangat secara pengalaman.</h2>
        </div>
        <div>
            <p>{{ $siteDescription }}</p>
            <div class="home-proof-grid">
                <div><i class="bi bi-check2-circle"></i> Pembiasaan ibadah dan karakter</div>
                <div><i class="bi bi-chat-heart"></i> Relasi dekat dengan wali murid</div>
                <div><i class="bi bi-award"></i> Akademik, adab, dan prestasi</div>
            </div>
        </div>
    </div>
</section>

@if($featureList->count() > 0)
<section class="home-section home-features">
    <div class="home-wrap">
        <div class="home-section-head">
            <div>
                <div class="home-section-label">Keunggulan</div>
                <h2>Program sekolah terasa hidup dari aktivitas hariannya.</h2>
            </div>
        </div>
        <div class="home-feature-grid">
            @foreach($featureList->take(4) as $feature)
            <article>
                <i class="{{ $feature->icon ?: 'bi bi-award' }}"></i>
                <h3>{{ $feature->title }}</h3>
                <p>{{ $feature->description }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($programList->count() > 0)
<section id="programs" class="home-section home-programs">
    <div class="home-wrap">
        <div class="home-section-head">
            <div>
                <div class="home-section-label">Program Unggulan</div>
                <h2>Ruang belajar yang terlihat, bukan sekadar daftar.</h2>
            </div>
            <a class="home-btn home-btn-gold" href="{{ route('programs.index') }}">Semua Program</a>
        </div>
        <div class="home-program-grid">
            @foreach($programList->take(3) as $program)
            <article class="home-program-card">
                <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('programs.show', $program->slug ?? '', 'Detail program tidak tersedia') }}">
                    @if($program->featured_image)
                        <img src="{{ asset('storage/' . $program->featured_image) }}" alt="{{ $program->title }}">
                    @else
                        <span><i class="bi bi-journal-richtext"></i></span>
                    @endif
                    <div>
                        <small>Program Pendidikan</small>
                        <h3>{{ $program->title }}</h3>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($postList->count() > 0)
<section class="home-section home-activity">
    <div class="home-wrap">
        <div class="home-section-head">
            <div>
                <div class="home-section-label">Kabar YASMU</div>
                <h2>Aktivitas terbaru tampil sebagai cerita.</h2>
            </div>
            <a class="home-btn home-btn-glass" href="{{ route('posts.index') }}">Semua Berita</a>
        </div>
        <div class="home-news-grid">
            @foreach($postList->take(4) as $post)
            <article>
                <a href="{{ \App\Helpers\RouteHelper::safeRouteWithMessage('posts.show', $post->slug ?? '', 'Detail artikel tidak tersedia') }}">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                    @else
                        <span><i class="bi bi-newspaper"></i></span>
                    @endif
                    <div>
                        <time>{{ $post->created_at->format('d M Y') }}</time>
                        <h3>{{ $post->title }}</h3>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="home-metric-band">
    <div class="home-wrap home-metrics">
        <div class="home-metrics-title">
            <div class="home-section-label">Data Yayasan</div>
            <h2>Angka dibuat terasa bernilai.</h2>
        </div>
        @forelse($statisticList->take(4) as $statistic)
            <div class="home-metric"><b>{{ $statistic->value }}</b><span>{{ $statistic->title }}</span></div>
        @empty
            <div class="home-metric"><b>{{ $programCount }}</b><span>Program unggulan</span></div>
            <div class="home-metric"><b>{{ $testimonialCount }}</b><span>Testimoni keluarga</span></div>
            <div class="home-metric"><b>{{ $serviceCount }}</b><span>Akses cepat</span></div>
            <div class="home-metric"><b>24</b><span>Layanan informasi</span></div>
        @endforelse
    </div>
</section>

@if($testimonialList->count() > 0)
<section class="home-section home-voices">
    <div class="home-wrap home-voices-grid">
        <div>
            <div class="home-section-label">Testimoni</div>
            <h2>Kesan dari keluarga besar YASMU.</h2>
        </div>
        <div class="home-voice-list">
            @foreach($testimonialList->take(2) as $testimonial)
            <figure>
                <blockquote>{{ $testimonial->testimonial }}</blockquote>
                <figcaption>
                    @if($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}">
                    @else
                        <span><i class="bi bi-person"></i></span>
                    @endif
                    <div>
                        <strong>{{ $testimonial->name }}</strong>
                        @if($testimonial->position || $testimonial->company)
                            <small>{{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ' - ' : '' }}{{ $testimonial->company }}</small>
                        @endif
                    </div>
                </figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

<footer class="home-footer">
    <div class="home-wrap">
        <div class="home-footer-panel">
            <div class="home-footer-main">
                <div class="home-kicker"><i class="bi bi-stars"></i> Kontak Beranda</div>
                <h2>Pilih CP lembaga yang tepat, lalu mulai percakapan.</h2>
                <p>Footer beranda ini menjadi pusat aksi terakhir. Untuk sementara pilihan lembaga memakai nomor WhatsApp global dari Site Settings dengan pesan otomatis sesuai lembaga tujuan.</p>
            </div>
            <div class="home-footer-contact">
                <h3>Hubungi via WhatsApp</h3>
                <p>Modul CP per lembaga belum tersedia di admin. Struktur ini siap dihubungkan setelah modul dibuat.</p>
                <div class="home-wa-options">
                    @foreach($institutionContactsResolved as $contact)
                        @php
                            $contactMessage = 'Halo, saya ingin menghubungi ' . $contact->name . ' YASMU Manyar.';
                            $contactUrl = \App\Helpers\ContactHelper::whatsappUrl($contact->phone ?? null, $contactMessage);
                            $contactDescription = $contact->contact_person
                                ? $contact->contact_person . ' - ' . ($contact->description ?: 'Informasi lembaga')
                                : ($contact->description ?: 'Informasi lembaga');
                        @endphp
                        @if($contactUrl)
                            <a class="home-wa-option" href="{{ $contactUrl }}" target="_blank" rel="noopener noreferrer">
                                <i class="{{ $contact->icon ?: 'bi bi-whatsapp' }}"></i>
                                <span><strong>{{ $contact->name }}</strong><span>{{ $contactDescription }}</span></span>
                                <small>Chat</small>
                            </a>
                        @else
                            <a class="home-wa-option" href="{{ route('contacts.index') }}">
                                <i class="{{ $contact->icon ?: 'bi bi-chat-dots' }}"></i>
                                <span><strong>{{ $contact->name }}</strong><span>{{ $contactDescription }}</span></span>
                                <small>Kontak</small>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="home-footer-bottom">
            <div class="home-footer-brand">
                @if(isset($siteSettings) && $siteSettings->logo)
                    <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="{{ $siteName }}">
                @endif
                <div>
                    <h4>{{ $siteName }}</h4>
                    <p>{{ $siteDescription }}</p>
                </div>
            </div>
            <div>
                <h4>Navigasi</h4>
                <div class="home-footer-links">
                    <a href="{{ route('programs.index') }}">Program</a>
                    <a href="{{ route('posts.index') }}">Berita</a>
                    <a href="{{ route('galleries.index') }}">Galeri</a>
                    <a href="{{ route('downloads.index') }}">Download</a>
                </div>
            </div>
            <div>
                <h4>Kontak Yayasan</h4>
                <p>
                    {{ $siteSettings->address ?? 'Alamat yayasan belum diatur.' }}<br>
                    {{ $siteSettings->email ?? 'Email belum diatur.' }}<br>
                    {{ $siteSettings->phone ?? 'Telepon belum diatur.' }}
                </p>
            </div>
        </div>
    </div>
</footer>
@endsection

@push('styles')
<style>
:root {
    --home-ink: #111827;
    --home-muted: #667085;
    --home-paper: #fbfaf6;
    --home-panel: #ffffff;
    --home-line: rgba(17, 24, 39, 0.11);
    --home-green: #12664f;
    --home-gold: #dda937;
    --home-coral: #bd5444;
    --home-deep: #17251f;
    --home-shadow: 0 30px 90px rgba(22, 31, 48, 0.18);
}

body {
    background: var(--home-paper) !important;
}

.footer {
    display: none;
}

.home-wrap {
    width: min(1440px, calc(100% - 48px));
    margin: 0 auto;
}

.home-hero {
    position: relative;
    min-height: calc(100vh - 118px);
    overflow: hidden;
    background: var(--home-deep);
    color: #ffffff;
}

.home-hero-media {
    position: absolute;
    inset: 0;
}

.home-hero-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    filter: saturate(1.08) contrast(1.02);
    transition: opacity 0.48s ease, transform 0.48s ease;
}

.home-hero-media::after {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(90deg, rgba(12, 19, 29, 0.92), rgba(12, 19, 29, 0.72) 42%, rgba(12, 19, 29, 0.2)),
        linear-gradient(0deg, rgba(12, 19, 29, 0.86), rgba(12, 19, 29, 0) 58%);
}

.home-hero-grid {
    position: relative;
    z-index: 1;
    min-height: calc(100vh - 118px);
    display: grid;
    grid-template-columns: minmax(0, 1.08fr) minmax(340px, 0.56fr);
    gap: clamp(28px, 5vw, 72px);
    align-items: center;
    padding: 42px 0 36px;
}

.home-kicker,
.home-section-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--home-gold);
    font-size: 0.82rem;
    font-weight: 900;
    text-transform: uppercase;
}

.home-hero-copy h1 {
    color: #ffffff;
    max-width: 820px;
    margin: 16px 0 22px;
    font-size: clamp(2.75rem, 5vw, 5.25rem);
    line-height: 1;
    font-weight: 900;
}

.home-hero-copy p {
    max-width: 720px;
    color: rgba(255, 255, 255, 0.82);
    font-size: 1.06rem;
    line-height: 1.75;
    margin: 0 0 26px;
}

.home-hero-copy h1,
.home-hero-copy p,
.home-actions {
    transition: opacity 0.42s ease, transform 0.42s ease;
}

.home-hero.is-changing .home-hero-media img,
.home-hero.is-changing .home-hero-copy h1,
.home-hero.is-changing .home-hero-copy p,
.home-hero.is-changing .home-actions {
    opacity: 0.18;
    transform: translateY(8px);
}

.home-actions,
.home-cta-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.home-btn {
    min-height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 12px;
    padding: 0 18px;
    font-weight: 900;
    text-decoration: none;
    border: 1px solid transparent;
}

.home-btn-gold {
    background: var(--home-gold);
    color: #111827 !important;
}

.home-btn-glass {
    color: #ffffff !important;
    border-color: rgba(255, 255, 255, 0.32);
    background: rgba(255, 255, 255, 0.11);
    backdrop-filter: blur(16px);
}

.home-live-card {
    border: 1px solid rgba(255, 255, 255, 0.26);
    background: rgba(255, 255, 255, 0.13);
    backdrop-filter: blur(24px);
    border-radius: 22px;
    padding: 18px;
    box-shadow: var(--home-shadow);
}

.home-live-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.24);
}

.home-live-head span,
.home-live-grid span {
    color: rgba(255, 255, 255, 0.7);
    font-weight: 800;
}

.home-live-head strong {
    display: block;
    color: #ffffff;
}

.home-live-dot {
    width: 12px;
    height: 12px;
    border-radius: 999px;
    background: #60d394;
    box-shadow: 0 0 0 8px rgba(96, 211, 148, 0.18);
}

.home-live-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-top: 16px;
}

.home-live-grid div {
    min-height: 104px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.13);
    padding: 15px;
}

.home-live-grid b {
    display: block;
    color: #ffffff;
    font-size: 2.4rem;
    line-height: 1;
}

.home-live-grid span {
    display: block;
    margin-top: 8px;
}

.home-quick {
    padding: 18px 0 0;
    background: var(--home-paper);
}

.home-quick-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
    border-radius: 24px;
    background: #ffffff;
    padding: 12px;
    box-shadow: var(--home-shadow);
}

.home-quick-grid a {
    min-height: 76px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 16px;
    background: #f3f7f1;
    padding: 14px;
    color: var(--home-ink) !important;
    font-weight: 900;
    text-decoration: none;
}

.home-quick-grid i {
    color: var(--home-green);
    font-size: 1.4rem;
}

.home-section {
    padding: 96px 0;
}

.home-story,
.home-programs,
.home-voices,
.home-metric-band {
    background: #ffffff;
}

.home-features,
.home-activity {
    background: var(--home-paper);
}

.home-section-head {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 28px;
    margin-bottom: 34px;
}

.home-section h2,
.home-metrics-title h2,
.home-footer-main h2 {
    max-width: 920px;
    margin: 10px 0 0;
    font-size: clamp(1.95rem, 3.2vw, 3.55rem);
    line-height: 1.04;
    font-weight: 900;
}

.home-story-grid,
.home-voices-grid {
    display: grid;
    grid-template-columns: minmax(340px, 0.8fr) minmax(0, 1.2fr);
    gap: clamp(28px, 5vw, 72px);
    align-items: start;
}

.home-story p {
    margin: 0;
    color: var(--home-muted);
    font-size: 1.08rem;
    line-height: 1.9;
}

.home-proof-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 28px;
}

.home-proof-grid div {
    min-height: 138px;
    border: 1px solid var(--home-line);
    background: #ffffff;
    border-radius: 18px;
    padding: 18px;
    font-weight: 900;
}

.home-proof-grid i {
    display: block;
    color: var(--home-coral);
    font-size: 1.45rem;
    margin-bottom: 18px;
}

.home-feature-grid {
    display: grid;
    grid-template-columns: 1.25fr 1fr 1fr;
    grid-auto-rows: minmax(190px, auto);
    gap: 14px;
}

.home-feature-grid article {
    border-radius: 20px;
    border: 1px solid var(--home-line);
    background: #ffffff;
    padding: 24px;
}

.home-feature-grid article:first-child {
    grid-row: span 2;
    background: var(--home-deep);
    color: #ffffff;
}

.home-feature-grid i {
    width: 50px;
    height: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: #edf4ef;
    color: var(--home-green);
    font-size: 1.45rem;
    margin-bottom: 22px;
}

.home-feature-grid h3,
.home-news-grid h3 {
    font-size: 1.08rem;
    line-height: 1.42;
    font-weight: 900;
}

.home-feature-grid p {
    color: var(--home-muted);
    line-height: 1.68;
}

.home-feature-grid article:first-child p,
.home-feature-grid article:first-child h3 {
    color: #ffffff;
}

.home-program-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.18fr) minmax(360px, 0.82fr);
    grid-template-rows: minmax(250px, 30vh) minmax(250px, 30vh);
    gap: 14px;
}

.home-program-card,
.home-news-grid article {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    background: var(--home-deep);
}

.home-program-card:first-child {
    grid-row: span 2;
}

.home-program-card a,
.home-news-grid a {
    display: block;
    height: 100%;
    color: #ffffff !important;
    text-decoration: none;
}

.home-program-card img,
.home-news-grid img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.82;
}

.home-program-card a::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(0deg, rgba(10, 20, 28, 0.82), rgba(10, 20, 28, 0.02) 64%);
}

.home-program-card div {
    position: absolute;
    left: 22px;
    right: 22px;
    bottom: 20px;
    z-index: 1;
}

.home-program-card small {
    color: var(--home-gold);
    font-weight: 900;
}

.home-program-card h3 {
    font-size: 1.55rem;
    margin: 8px 0 0;
}

.home-activity {
    background: var(--home-deep);
    color: #ffffff;
}

.home-activity h2 {
    color: #ffffff;
}

.home-news-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}

.home-news-grid article {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.home-news-grid img,
.home-news-grid a > span {
    width: 100%;
    aspect-ratio: 16 / 11;
    object-fit: cover;
}

.home-news-grid a > span {
    display: flex;
    align-items: center;
    justify-content: center;
}

.home-news-grid div {
    padding: 18px;
}

.home-news-grid time {
    color: var(--home-gold);
    font-size: 0.82rem;
    font-weight: 900;
}

.home-news-grid h3 {
    color: #ffffff;
    margin: 10px 0 0;
}

.home-metric-band {
    padding: 70px 0;
}

.home-metrics {
    display: grid;
    grid-template-columns: minmax(260px, 0.8fr) repeat(4, minmax(0, 1fr));
    gap: 12px;
    align-items: stretch;
}

.home-metrics-title {
    border-radius: 22px;
    background: var(--home-green);
    color: #ffffff;
    padding: 24px;
}

.home-metrics-title h2 {
    color: #ffffff;
    font-size: 2rem;
}

.home-metric {
    border-radius: 22px;
    background: var(--home-paper);
    border: 1px solid var(--home-line);
    padding: 22px;
}

.home-metric b {
    display: block;
    font-size: 2.6rem;
    line-height: 1;
}

.home-metric span {
    display: block;
    margin-top: 12px;
    color: var(--home-muted);
    font-weight: 900;
}

.home-voice-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.home-voice-list figure {
    margin: 0;
    border-radius: 20px;
    background: #ffffff;
    border: 1px solid var(--home-line);
    padding: 24px;
}

.home-voice-list blockquote {
    line-height: 1.8;
    margin: 0 0 24px;
}

.home-voice-list figcaption {
    display: flex;
    align-items: center;
    gap: 12px;
}

.home-voice-list img,
.home-voice-list figcaption > span {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    object-fit: cover;
    background: #e7f1ed;
    color: var(--home-green);
    display: flex;
    align-items: center;
    justify-content: center;
}

.home-voice-list strong,
.home-voice-list small {
    display: block;
}

.home-voice-list small {
    color: var(--home-muted);
}

.home-footer {
    background: #101825;
    color: #ffffff;
    padding: 86px 0 28px;
}

.home-footer-panel {
    display: grid;
    grid-template-columns: minmax(0, 1.16fr) minmax(460px, 0.84fr);
    gap: clamp(24px, 4vw, 54px);
    align-items: stretch;
    margin-bottom: 42px;
}

.home-footer-main {
    border-radius: 28px;
    background:
        linear-gradient(135deg, rgba(221, 169, 55, 0.18), rgba(18, 102, 79, 0.12)),
        rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.12);
    padding: clamp(28px, 5vw, 58px);
}

.home-footer-main h2 {
    color: #ffffff;
    max-width: 940px;
    font-size: clamp(2rem, 3.6vw, 4rem);
}

.home-footer-main p {
    max-width: 840px;
    color: rgba(255, 255, 255, 0.72);
    line-height: 1.85;
    margin: 18px 0 0;
}

.home-footer-contact {
    border-radius: 28px;
    background: #ffffff;
    color: var(--home-ink);
    padding: 24px;
    box-shadow: var(--home-shadow);
}

.home-footer-contact h3 {
    margin: 0 0 8px;
    font-size: 1.35rem;
    font-weight: 900;
}

.home-footer-contact > p {
    margin: 0 0 18px;
    color: var(--home-muted);
    line-height: 1.65;
}

.home-wa-options {
    display: grid;
    gap: 10px;
}

.home-wa-option {
    display: grid;
    grid-template-columns: 44px 1fr auto;
    gap: 12px;
    align-items: center;
    border-radius: 16px;
    background: #f5f7f2;
    border: 1px solid var(--home-line);
    padding: 12px;
    color: var(--home-ink) !important;
    text-decoration: none;
}

.home-wa-option i {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: var(--home-green);
    color: #ffffff;
    font-size: 1.25rem;
}

.home-wa-option strong,
.home-wa-option span {
    display: block;
}

.home-wa-option span span {
    color: var(--home-muted);
    font-size: 0.82rem;
    margin-top: 3px;
}

.home-wa-option small {
    color: var(--home-green);
    font-weight: 900;
}

.home-footer-bottom {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr 0.8fr;
    gap: 26px;
    padding-top: 28px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.home-footer-brand {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

.home-footer-brand img {
    width: 54px;
    height: 54px;
    object-fit: contain;
    border-radius: 14px;
    background: #ffffff;
    padding: 6px;
}

.home-footer-bottom h4 {
    margin: 0 0 12px;
    font-size: 0.95rem;
    font-weight: 900;
}

.home-footer-bottom p,
.home-footer-bottom a {
    color: rgba(255, 255, 255, 0.68) !important;
    line-height: 1.75;
    font-size: 0.92rem;
    text-decoration: none;
}

.home-footer-links {
    display: grid;
    gap: 7px;
}

@media (min-width: 1600px) {
    .home-wrap {
        width: min(1560px, calc(100% - 80px));
    }

    .home-hero-copy h1 {
        font-size: 5.65rem;
    }
}

@media (max-width: 1180px) {
    .home-hero-grid {
        grid-template-columns: minmax(0, 1fr) 320px;
    }

    .home-hero-copy h1 {
        font-size: clamp(2.65rem, 6vw, 4.6rem);
    }

    .home-footer-panel,
    .home-metrics {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 980px) {
    .home-hero-grid,
    .home-story-grid,
    .home-footer-bottom,
    .home-metrics,
    .home-program-grid,
    .home-voices-grid {
        grid-template-columns: 1fr;
    }

    .home-quick-grid,
    .home-news-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .home-program-grid {
        grid-template-rows: none;
    }

    .home-program-card,
    .home-program-card:first-child {
        grid-row: auto;
        min-height: 280px;
    }

    .home-feature-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .home-feature-grid article:first-child {
        grid-row: auto;
    }
}

@media (max-width: 640px) {
    .home-wrap {
        width: min(100% - 28px, 1440px);
    }

    .home-hero,
    .home-hero-grid {
        min-height: auto;
    }

    .home-hero-grid {
        padding: 54px 0 34px;
    }

    .home-hero-copy h1 {
        font-size: clamp(2.35rem, 12vw, 3.1rem);
        line-height: 1.04;
    }

    .home-live-card {
        display: none;
    }

    .home-quick-grid,
    .home-proof-grid,
    .home-metrics,
    .home-news-grid,
    .home-feature-grid,
    .home-voice-list {
        grid-template-columns: 1fr;
    }

    .home-section-head {
        display: block;
    }

    .home-footer-panel {
        gap: 18px;
    }

    .home-footer-contact {
        padding: 18px;
    }

    .home-wa-option {
        grid-template-columns: 40px 1fr;
    }

    .home-wa-option small {
        grid-column: 2;
    }
}

@media (max-width: 480px) {
    .home-actions {
        width: 100%;
    }

    .home-btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const heroSlides = {{ \Illuminate\Support\Js::from($heroSlides->values()) }};
    const hero = document.querySelector('[data-home-hero]');

    if (!hero || heroSlides.length < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const headline = hero.querySelector('[data-hero-headline]');
    const description = hero.querySelector('[data-hero-description]');
    const image = hero.querySelector('[data-hero-image]');
    const primary = hero.querySelector('[data-hero-primary]');
    const buttonText = hero.querySelector('[data-hero-button-text]');
    const intervalMs = 6000;
    let activeIndex = 0;
    let timer = null;

    heroSlides.forEach((slide) => {
        if (!slide.image) {
            return;
        }

        const preload = new Image();
        preload.src = slide.image;
    });

    const renderSlide = (slide) => {
        hero.classList.add('is-changing');

        window.setTimeout(() => {
            headline.textContent = slide.headline;
            description.textContent = slide.description;
            primary.href = slide.buttonLink;
            buttonText.textContent = slide.buttonText;

            if (slide.image) {
                image.hidden = false;
                image.src = slide.image;
                image.alt = slide.headline;
            } else {
                image.hidden = true;
                image.removeAttribute('src');
                image.alt = '';
            }

            window.setTimeout(() => hero.classList.remove('is-changing'), 80);
        }, 260);
    };

    const nextSlide = () => {
        activeIndex = (activeIndex + 1) % heroSlides.length;
        renderSlide(heroSlides[activeIndex]);
    };

    const startRotation = () => {
        if (timer || document.hidden) {
            return;
        }

        timer = window.setInterval(nextSlide, intervalMs);
    };

    const stopRotation = () => {
        if (!timer) {
            return;
        }

        window.clearInterval(timer);
        timer = null;
    };

    hero.addEventListener('mouseenter', stopRotation);
    hero.addEventListener('mouseleave', startRotation);
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopRotation();
        } else {
            startRotation();
        }
    });

    startRotation();
});
</script>
@endpush
