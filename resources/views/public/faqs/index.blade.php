@extends('layouts.public')

@section('title', 'FAQ - ' . $siteSettings->site_name)
@section('description', 'Pertanyaan yang sering diajukan seputar ' . $siteSettings->site_name)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-question-circle me-3"></i>FAQ
                </h1>
                <p class="lead text-muted">Pertanyaan yang sering diajukan dan jawabannya</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('faqs.index') }}" class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Cari pertanyaan...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQs Accordion -->
    <div class="row">
        <div class="col-12">
            @forelse($faqs as $index => $faq)
                <div class="card shadow-sm border-0 mb-3 modern-card">
                    <div class="card-header" style="background-color: var(--section-bg-color);">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-decoration-none w-100 text-start p-0" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#faq{{ $faq->id }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                    aria-controls="faq{{ $faq->id }}"
                                    style="color: var(--primary-color); font-weight: 600;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-question-circle me-3" style="font-size: 1.2rem;"></i>
                                    <span class="flex-grow-1">{{ $faq->question }}</span>
                                    <i class="bi bi-chevron-down ms-2" id="icon{{ $faq->id }}"></i>
                                </div>
                            </button>
                        </h5>
                    </div>
                    <div id="faq{{ $faq->id }}" 
                         class="collapse {{ $index === 0 ? 'show' : '' }}" 
                         data-bs-parent="#faqAccordion">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-chat-dots me-3 mt-1" style="color: var(--primary-color); font-size: 1.2rem;"></i>
                                <div class="flex-grow-1">
                                    <div class="faq-answer">
                                        {!! $faq->answer !!}
                                    </div>
                                    @if($faq->tags)
                                        <div class="mt-3 pt-3 border-top">
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach(explode(',', $faq->tags) as $tag)
                                                    <span class="badge bg-light text-dark border">
                                                        #{{ trim($tag) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-question-circle display-1 text-muted"></i>
                    <h3 class="mt-3">Tidak ada FAQ ditemukan</h3>
                    <p class="text-muted">Coba gunakan kata kunci lain</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                <div class="card-body text-center text-white p-5">
                    <h3 class="mb-3">
                        <i class="bi bi-headset me-2"></i>Tidak Menemukan Jawaban?
                    </h3>
                    <p class="lead mb-4">Tim kami siap membantu menjawab pertanyaan Anda</p>
                    <a href="{{ route('contacts.index') }}" 
                       class="btn btn-light btn-lg px-4">
                        <i class="bi bi-envelope me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modern-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.btn-link {
    text-decoration: none !important;
}

.btn-link:hover {
    text-decoration: none !important;
}

.btn-link:focus {
    box-shadow: none !important;
}

.faq-answer {
    line-height: 1.8;
    font-size: 1.1rem;
}

.faq-answer h1, .faq-answer h2, .faq-answer h3, 
.faq-answer h4, .faq-answer h5, .faq-answer h6 {
    color: var(--primary-color);
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.faq-answer img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
}

.faq-answer ul, .faq-answer ol {
    padding-left: 1.5rem;
}

.faq-answer li {
    margin-bottom: 0.5rem;
}

/* Accordion icon rotation */
.collapse.show + .card-header .bi-chevron-down {
    transform: rotate(180deg);
}

.bi-chevron-down {
    transition: transform 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle accordion icon rotation
    const accordionButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const icon = document.querySelector(`#icon${targetId.replace('#faq', '')}`);
            
            if (icon) {
                setTimeout(() => {
                    const isExpanded = document.querySelector(targetId).classList.contains('show');
                    if (isExpanded) {
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }, 100);
            }
        });
    });
});
</script>
@endsection
