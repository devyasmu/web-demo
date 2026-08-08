@extends('layouts.admin')

@section('title', 'Kelola Komentar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="bi bi-chat-dots me-2"></i>Kelola Komentar
                    </h3>
                    <div class="d-flex gap-2">
                        <span class="badge bg-warning">{{ $comments->where('is_approved', false)->count() }} Pending</span>
                        <span class="badge bg-success">{{ $comments->where('is_approved', true)->count() }} Approved</span>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="card-body border-bottom">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="item_type" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="App\Models\Post" {{ request('item_type') === 'App\Models\Post' ? 'selected' : '' }}>Posts</option>
                                <option value="App\Models\Announcement" {{ request('item_type') === 'App\Models\Announcement' ? 'selected' : '' }}>Announcements</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau komentar..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Bulk Actions -->
                <div class="card-body border-bottom" id="bulkActions" style="display: none;">
                    <form method="POST" id="bulkForm">
                        @csrf
                        <div class="d-flex gap-2">
                            <button type="submit" formaction="{{ route('admin.comments.bulk-approve') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle me-1"></i>Approve Selected
                            </button>
                            <button type="submit" formaction="{{ route('admin.comments.bulk-reject') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-x-circle me-1"></i>Reject Selected
                            </button>
                            <button type="submit" formaction="{{ route('admin.comments.bulk-delete') }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus komentar terpilih?')">
                                <i class="bi bi-trash me-1"></i>Delete Selected
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    @if($comments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>Komentar</th>
                                        <th width="200">Item</th>
                                        <th width="120">Status</th>
                                        <th width="150">Tanggal</th>
                                        <th width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comments as $comment)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" class="form-check-input comment-checkbox">
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $comment->name }}</h6>
                                                    <p class="mb-1 text-muted small">{{ $comment->email }}</p>
                                                    <p class="mb-0">{{ Str::limit($comment->content, 100) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <strong>{{ class_basename($comment->commentable_type) }}</strong><br>
                                                <span class="text-muted">{{ Str::limit($comment->commentable->title ?? 'N/A', 30) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($comment->is_approved)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Approved
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock me-1"></i>Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ $comment->created_at->format('d M Y') }}<br>
                                                <span class="text-muted">{{ $comment->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                @if(!$comment->is_approved)
                                                    <a href="{{ route('admin.comments.approve', $comment) }}" 
                                                       class="btn btn-success btn-sm" 
                                                       title="Approve">
                                                        <i class="bi bi-check"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.comments.reject', $comment) }}" 
                                                       class="btn btn-warning btn-sm" 
                                                       title="Reject">
                                                        <i class="bi bi-x"></i>
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('admin.comments.edit', $comment) }}" 
                                                   class="btn btn-primary btn-sm" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Yakin hapus komentar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $comments->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-chat-dots display-1 text-muted"></i>
                            <h5 class="mt-3">Tidak ada komentar</h5>
                            <p class="text-muted">Belum ada komentar yang masuk.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const commentCheckboxes = document.querySelectorAll('.comment-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const bulkForm = document.getElementById('bulkForm');

    // Check if elements exist before adding event listeners
    if (selectAllCheckbox) {
        // Select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            commentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    // Individual checkbox change
    commentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkActions();
            updateSelectAll();
        });
    });

    function toggleBulkActions() {
        const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
        if (bulkActions) {
            bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
        }
    }

    function updateSelectAll() {
        const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
        const totalBoxes = commentCheckboxes.length;
        
        if (selectAllCheckbox) {
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedBoxes.length === totalBoxes) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }

    // Bulk form submission
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Pilih komentar terlebih dahulu!');
                return;
            }

            // Add checked comment IDs to form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'comment_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });
    }
});
</script>
@endsection
