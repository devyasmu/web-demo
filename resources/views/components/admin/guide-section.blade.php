@props(['id', 'title', 'icon' => 'bi bi-info-circle', 'admin' => null, 'public' => null, 'where' => null])

<section id="{{ $id }}" class="card guide-section mb-4" data-guide-section>
    <div class="card-header d-flex flex-wrap align-items-center gap-2">
        <h5 class="mb-0 me-auto"><i class="{{ $icon }} me-2"></i>{{ $title }}</h5>
        @if($admin)
            <a href="{{ $admin }}" class="btn btn-sm btn-primary guide-no-print"><i class="bi bi-box-arrow-up-right me-1"></i>Buka menu</a>
        @endif
        @if($public)
            <a href="{{ $public }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary guide-no-print"><i class="bi bi-eye me-1"></i>Lihat di website</a>
        @endif
    </div>
    <div class="card-body">
        @if($where)
            <p class="guide-where"><i class="bi bi-geo-alt me-1"></i><strong>Tampil di:</strong> {{ $where }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
