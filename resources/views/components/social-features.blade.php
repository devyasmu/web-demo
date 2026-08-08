@props(['item', 'itemType' => 'post', 'itemId' => null, 'likesCount' => 0, 'commentsCount' => 0])

<div class="mt-4 pt-3 border-top">
    <div class="row align-items-center">
        <div class="col-md-6">
            <!-- Like Button -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-danger btn-sm like-btn" data-{{ $itemType }}-id="{{ $itemId ?? $item->id }}">
                    <i class="bi bi-heart me-1"></i>
                    <span class="like-count">{{ $likesCount }}</span>
                </button>
                
                <!-- Comment Button -->
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#commentsSection">
                    <i class="bi bi-chat-dots me-1"></i>
                    <span class="comment-count">{{ $commentsCount }}</span>
                </button>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Social Share Buttons -->
            <div class="d-flex justify-content-md-end gap-2 mt-2 mt-md-0">
                <span class="text-muted me-2">Bagikan:</span>
                
                <!-- Facebook Share -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank" class="btn btn-outline-primary btn-sm social-share-btn" 
                   data-bs-toggle="tooltip" title="Share on Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                
                <!-- WhatsApp Share -->
                <a href="https://wa.me/?text={{ urlencode($item->title . ' - ' . request()->fullUrl()) }}" 
                   target="_blank" class="btn btn-outline-success btn-sm social-share-btn"
                   data-bs-toggle="tooltip" title="Share on WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                
                <!-- Twitter Share -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($item->title) }}&url={{ urlencode(request()->fullUrl()) }}" 
                   target="_blank" class="btn btn-outline-info btn-sm social-share-btn"
                   data-bs-toggle="tooltip" title="Share on Twitter">
                    <i class="bi bi-twitter"></i>
                </a>
                
                <!-- Instagram Share (Copy Link) -->
                <button class="btn btn-outline-danger btn-sm social-share-btn" 
                        onclick="copyToClipboard('{{ request()->fullUrl() }}')"
                        data-bs-toggle="tooltip" title="Copy Link for Instagram">
                    <i class="bi bi-instagram"></i>
                </button>
                
                <!-- TikTok Share (Copy Link) -->
                <button class="btn btn-outline-dark btn-sm social-share-btn" 
                        onclick="copyToClipboard('{{ request()->fullUrl() }}')"
                        data-bs-toggle="tooltip" title="Copy Link for TikTok">
                    <i class="bi bi-tiktok"></i>
                </button>
                
                <!-- Copy Link -->
                <button class="btn btn-outline-secondary btn-sm social-share-btn" 
                        onclick="copyToClipboard('{{ request()->fullUrl() }}')"
                        data-bs-toggle="tooltip" title="Copy Link">
                    <i class="bi bi-link-45deg"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Comments Section -->
<div class="collapse mt-4" id="commentsSection">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">
                <i class="bi bi-chat-dots me-2"></i>Komentar
                <span class="badge bg-primary ms-2 comment-count">{{ $commentsCount }}</span>
            </h6>
        </div>
        <div class="card-body">
            <!-- Comment Form -->
            <form id="commentForm" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="commenter_name" class="form-label">Nama *</label>
                    <input type="text" class="form-control" id="commenter_name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="commenter_email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="commenter_email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="comment_content" class="form-label">Komentar *</label>
                    <textarea class="form-control" id="comment_content" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Kirim Komentar
                </button>
            </form>
            
            <!-- Comments List -->
            <div id="commentsList">
                @if($item->approvedComments && $item->approvedComments->count() > 0)
                    @foreach($item->approvedComments as $comment)
                        <div class="comment-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold">{{ $comment->name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-chat-dots fs-1"></i>
                        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Social Features Styles */
.social-share-btn {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.social-share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.like-btn {
    transition: all 0.3s ease;
}

.like-btn.liked {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.like-btn.liked i {
    animation: heartBeat 0.6s ease-in-out;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.comment-item {
    border-bottom: 1px solid #eee;
    padding: 1rem 0;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-author {
    font-weight: 600;
    color: var(--primary-color);
}

.comment-date {
    font-size: 0.8rem;
    color: #6c757d;
}

.comment-content {
    margin-top: 0.5rem;
    line-height: 1.6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips (with Bootstrap check and delay)
    let tooltipRetryCount = 0;
    const maxTooltipRetries = 30; // 3 seconds max wait
    
    function initializeTooltips() {
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            console.log('Bootstrap tooltips initialized successfully');
        } else if (tooltipRetryCount < maxTooltipRetries) {
            tooltipRetryCount++;
            setTimeout(initializeTooltips, 100);
        } else {
            console.warn('Bootstrap Tooltip not available after timeout');
        }
    }
    
    // Start tooltip initialization
    initializeTooltips();

    // Like functionality
    const likeBtn = document.querySelector('.like-btn');
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const itemId = this.dataset['{{ $itemType }}Id'];
            const likeCount = this.querySelector('.like-count');
            
            // Disable button during request
            this.disabled = true;
            
            // Make API call
            fetch('{{ route("social.like") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    item_type: '{{ $itemType }}',
                    item_id: itemId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update visual state
                    if (data.liked) {
                        this.classList.add('liked');
                    } else {
                        this.classList.remove('liked');
                    }
                    
                    // Update count
                    likeCount.textContent = data.likes_count;
                } else {
                    showAlert('Gagal melakukan like. Silakan coba lagi.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Gagal melakukan like. Silakan coba lagi.', 'danger');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    }

    // Comment form submission
    const commentForm = document.getElementById('commentForm');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const itemId = {{ $itemId ?? $item->id }};
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Mengirim...';
            submitBtn.disabled = true;
            
            // Make API call
            console.log('Submitting comment...', {
                item_type: '{{ $itemType }}',
                item_id: itemId,
                name: formData.get('name'),
                email: formData.get('email'),
                content: formData.get('content')
            });
            
            fetch('{{ route("social.comment") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    item_type: 'App\\Models\\{{ ucfirst($itemType) }}',
                    item_id: itemId,
                    name: formData.get('name'),
                    email: formData.get('email'),
                    content: formData.get('content')
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Reset form
                    this.reset();
                    
                    // Show success message with approval notice
                    showAlert('Komentar berhasil dikirim! Komentar akan tampil setelah disetujui admin.', 'info');
                } else {
                    showAlert('Gagal mengirim komentar: ' + (data.message || 'Silakan coba lagi.'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Gagal mengirim komentar. Silakan coba lagi.', 'danger');
            })
            .finally(() => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showAlert('Link berhasil disalin!', 'success');
    }, function(err) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showAlert('Link berhasil disalin!', 'success');
    });
}

// Add comment to list
function addCommentToList(comment) {
    const commentsList = document.getElementById('commentsList');
    
    // Remove "no comments" message if exists
    const noCommentsMsg = commentsList.querySelector('.text-center');
    if (noCommentsMsg) {
        noCommentsMsg.remove();
    }
    
    // Create comment element
    const commentElement = document.createElement('div');
    commentElement.className = 'comment-item mb-3 p-3 border rounded';
    commentElement.innerHTML = `
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="mb-0 fw-bold">${comment.name}</h6>
            <small class="text-muted">${formatDate(comment.created_at)}</small>
        </div>
        <p class="mb-0">${comment.content}</p>
    `;
    
    // Add to top of comments list
    commentsList.insertBefore(commentElement, commentsList.firstChild);
}

// Update comment count
function updateCommentCount(newCount = null) {
    const commentCounts = document.querySelectorAll('.comment-count');
    commentCounts.forEach(count => {
        if (newCount !== null) {
            count.textContent = newCount;
        } else {
            const currentCount = parseInt(count.textContent);
            count.textContent = currentCount + 1;
        }
    });
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Show alert
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
