@extends('layouts.public')

@section('title', $post->title . ' - ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: var(--primary-color);">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}" style="color: var(--primary-color);">Artikel</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card shadow-sm border-0">
                @if($post->featured_image)
                    <div class="position-relative">
                        <img src="{{ Storage::url($post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="card-img-top" style="height: 400px; object-fit: cover;">
                        @if($post->featured)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-star-fill me-1"></i>Featured
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="card-body p-4">
                    <!-- Post Meta -->
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <span class="badge me-2 mb-2" style="background-color: var(--primary-color); color: white;">
                            {{ $post->category->name }}
                        </span>
                        <small class="text-muted me-3 mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->published_at->format('d F Y') }}
                        </small>
                        <small class="text-muted mb-2">
                            <i class="bi bi-clock me-1"></i>
                            {{ $post->published_at->format('H:i') }}
                        </small>
                    </div>

                    <!-- Post Title -->
                    <h1 class="display-5 fw-bold mb-4" style="color: var(--primary-color);">
                        {{ $post->title }}
                    </h1>

                    <!-- Post Content -->
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>

                    <!-- Social Features -->
                    <x-social-features 
                        :item="$post" 
                        item-type="post" 
                        :likes-count="$post->likes_count ?? 0" 
                        :comments-count="$post->comments_count ?? 0" 
                    />

                    <!-- Post Tags -->
                    @if($post->tags)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-2">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $post->tags) as $tag)
                                    <span class="badge bg-light text-dark border">
                                        #{{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-collection me-2"></i>Artikel Terkait
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="p-3 border-bottom">
                                <div class="d-flex">
                                    @if($relatedPost->featured_image)
                                        <img src="{{ Storage::url($relatedPost->featured_image) }}" 
                                             alt="{{ $relatedPost->title }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('posts.show', $relatedPost->slug) }}" 
                                               class="text-decoration-none" 
                                               style="color: var(--primary-color);">
                                                {{ Str::limit($relatedPost->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            {{ $relatedPost->published_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Other Posts -->
            @if($otherPosts->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: var(--primary-color); color: white;">
                        <h5 class="mb-0">
                            <i class="bi bi-newspaper me-2"></i>Artikel Lainnya
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($otherPosts as $otherPost)
                            <div class="p-3 border-bottom">
                                <div class="d-flex">
                                    @if($otherPost->featured_image)
                                        <img src="{{ Storage::url($otherPost->featured_image) }}" 
                                             alt="{{ $otherPost->title }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('posts.show', $otherPost->slug) }}" 
                                               class="text-decoration-none" 
                                               style="color: var(--primary-color);">
                                                {{ Str::limit($otherPost->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $otherPost->published_at->format('d M Y') }}
                                        </small>
                                        @if($otherPost->category)
                                            <div class="mt-1">
                                                <span class="badge bg-secondary">{{ $otherPost->category->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.post-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.post-content h1, .post-content h2, .post-content h3, 
.post-content h4, .post-content h5, .post-content h6 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
}

.post-content blockquote {
    border-left: 4px solid var(--primary-color);
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: var(--section-bg-color);
    padding: 1rem;
    border-radius: 5px;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: var(--primary-color);
}

@endsection
