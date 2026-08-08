@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pengaturan Website</h5>
            </div>
            <div class="card-body">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                            <i class="bi bi-gear"></i> Umum
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors" type="button" role="tab">
                            <i class="bi bi-palette"></i> Warna Website
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-colors-tab" data-bs-toggle="tab" data-bs-target="#admin-colors" type="button" role="tab">
                            <i class="bi bi-gear-fill"></i> Warna Admin
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                            <i class="bi bi-key"></i> Ubah Password
                        </button>
                    </li>
                </ul>

                <form action="{{ route('admin.site-settings.update', $siteSetting) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="tab-content" id="settingsTabsContent">
                        <!-- General Settings Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                               id="site_name" name="site_name" value="{{ old('site_name', $siteSetting->site_name) }}" required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_tagline" class="form-label">Tagline</label>
                                        <input type="text" class="form-control @error('site_tagline') is-invalid @enderror" 
                                               id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $siteSetting->site_tagline) }}">
                                        @error('site_tagline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="site_description" class="form-label">Deskripsi Website</label>
                                <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                          id="site_description" name="site_description" rows="3">{{ old('site_description', $siteSetting->site_description) }}</textarea>
                                @error('site_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo Website</label>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                               id="logo" name="logo" accept="image/*">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($siteSetting->logo)
                                            <div class="mt-2">
                                                <small class="text-muted">Logo saat ini:</small><br>
                                                <img src="{{ \App\Helpers\AssetHelper::safeAsset($siteSetting->logo) }}" alt="Current Logo" 
                                                     class="img-thumbnail" style="max-width: 150px; max-height: 80px;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <div style="display: none; padding: 10px; border: 1px dashed #ccc; text-align: center; color: #666;">
                                                    <i class="bi bi-image"></i><br>
                                                    <small>Logo tidak dapat dimuat</small><br>
                                                    <small>Path: {{ $siteSetting->logo }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="favicon" class="form-label">Favicon</label>
                                        <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                               id="favicon" name="favicon" accept="image/*">
                                        @error('favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($siteSetting->favicon)
                                            <div class="mt-2">
                                                <small class="text-muted">Favicon saat ini:</small><br>
                                                <img src="{{ \App\Helpers\AssetHelper::safeAsset($siteSetting->favicon) }}" alt="Current Favicon" 
                                                     class="img-thumbnail" style="max-width: 32px; max-height: 32px;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <div style="display: none; padding: 10px; border: 1px dashed #ccc; text-align: center; color: #666;">
                                                    <i class="bi bi-image"></i><br>
                                                    <small>Favicon tidak dapat dimuat</small><br>
                                                    <small>Path: {{ $siteSetting->favicon }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $siteSetting->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Telepon</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $siteSetting->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="2">{{ old('address', $siteSetting->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook URL</label>
                                        <input type="url" class="form-control @error('facebook') is-invalid @enderror" 
                                               id="facebook" name="facebook" value="{{ old('facebook', $siteSetting->facebook) }}">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram URL</label>
                                        <input type="url" class="form-control @error('instagram') is-invalid @enderror" 
                                               id="instagram" name="instagram" value="{{ old('instagram', $siteSetting->instagram) }}">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">YouTube URL</label>
                                        <input type="url" class="form-control @error('youtube') is-invalid @enderror" 
                                               id="youtube" name="youtube" value="{{ old('youtube', $siteSetting->youtube) }}">
                                        @error('youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter URL</label>
                                        <input type="url" class="form-control @error('twitter') is-invalid @enderror" 
                                               id="twitter" name="twitter" value="{{ old('twitter', $siteSetting->twitter) }}">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                               id="meta_title" name="meta_title" value="{{ old('meta_title', $siteSetting->meta_title) }}">
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                               id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $siteSetting->meta_keywords) }}"
                                               placeholder="keyword1, keyword2, keyword3">
                                        @error('meta_keywords')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $siteSetting->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Website Colors Tab -->
                        <div class="tab-pane fade" id="colors" role="tabpanel">
                            <h6 class="mb-3">Pengaturan Warna Website</h6>
                            
                            <!-- Theme Presets -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Preset Tema</h6>
                                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="resetTheme()">
                                        <i class="bi bi-arrow-clockwise"></i> Reset Tema
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-outline-primary w-100 preset-btn" data-preset="default">
                                                <i class="bi bi-palette"></i><br>
                                                <small>Default</small>
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-outline-success w-100 preset-btn" data-preset="green">
                                                <i class="bi bi-tree"></i><br>
                                                <small>Hijau</small>
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-outline-danger w-100 preset-btn" data-preset="red">
                                                <i class="bi bi-heart"></i><br>
                                                <small>Merah</small>
                                            </button>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="button" class="btn btn-outline-warning w-100 preset-btn" data-preset="orange">
                                                <i class="bi bi-sun"></i><br>
                                                <small>Orange</small>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-info btn-sm" id="testPresetBtn">
                                                <i class="bi bi-bug"></i> Test Preset
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm ms-2" onclick="testOrangePreset()">
                                                <i class="bi bi-sun"></i> Test Orange
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Warna Utama</h6>
                                    <div class="mb-3">
                                        <label for="primary_color" class="form-label">Warna Primer</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="primary_color" name="primary_color" 
                                                   value="{{ old('primary_color', $siteSetting->primary_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('primary_color', $siteSetting->primary_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('primary_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="secondary_color" class="form-label">Warna Sekunder</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="secondary_color" name="secondary_color" 
                                                   value="{{ old('secondary_color', $siteSetting->secondary_color ?? '#6c757d') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('secondary_color', $siteSetting->secondary_color ?? '#6c757d') }}" 
                                                   onchange="document.getElementById('secondary_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="accent_color" class="form-label">Warna Aksen</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="accent_color" name="accent_color" 
                                                   value="{{ old('accent_color', $siteSetting->accent_color ?? '#28a745') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('accent_color', $siteSetting->accent_color ?? '#28a745') }}" 
                                                   onchange="document.getElementById('accent_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Warna Background</h6>
                                    <div class="mb-3">
                                        <label for="header_bg_color" class="form-label">Background Header</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="header_bg_color" name="header_bg_color" 
                                                   value="{{ old('header_bg_color', $siteSetting->header_bg_color ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('header_bg_color', $siteSetting->header_bg_color ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('header_bg_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="footer_bg_color" class="form-label">Background Footer</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="footer_bg_color" name="footer_bg_color" 
                                                   value="{{ old('footer_bg_color', $siteSetting->footer_bg_color ?? '#343a40') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('footer_bg_color', $siteSetting->footer_bg_color ?? '#343a40') }}" 
                                                   onchange="document.getElementById('footer_bg_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="body_bg_color" class="form-label">Background Body</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="body_bg_color" name="body_bg_color" 
                                                   value="{{ old('body_bg_color', $siteSetting->body_bg_color ?? '#f8f9fa') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('body_bg_color', $siteSetting->body_bg_color ?? '#f8f9fa') }}" 
                                                   onchange="document.getElementById('body_bg_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Warna Teks</h6>
                                    <div class="mb-3">
                                        <label for="header_text_color" class="form-label">Teks Header</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="header_text_color" name="header_text_color" 
                                                   value="{{ old('header_text_color', $siteSetting->header_text_color ?? '#000000') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('header_text_color', $siteSetting->header_text_color ?? '#000000') }}" 
                                                   onchange="document.getElementById('header_text_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="footer_text_color" class="form-label">Teks Footer</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="footer_text_color" name="footer_text_color" 
                                                   value="{{ old('footer_text_color', $siteSetting->footer_text_color ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('footer_text_color', $siteSetting->footer_text_color ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('footer_text_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="body_text_color" class="form-label">Teks Body</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="body_text_color" name="body_text_color" 
                                                   value="{{ old('body_text_color', $siteSetting->body_text_color ?? '#333333') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('body_text_color', $siteSetting->body_text_color ?? '#333333') }}" 
                                                   onchange="document.getElementById('body_text_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Warna Tombol</h6>
                                    <div class="mb-3">
                                        <label for="button_primary_color" class="form-label">Tombol Primer</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="button_primary_color" name="button_primary_color" 
                                                   value="{{ old('button_primary_color', $siteSetting->button_primary_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('button_primary_color', $siteSetting->button_primary_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('button_primary_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="button_primary_hover" class="form-label">Tombol Primer Hover</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="button_primary_hover" name="button_primary_hover" 
                                                   value="{{ old('button_primary_hover', $siteSetting->button_primary_hover ?? '#0056b3') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('button_primary_hover', $siteSetting->button_primary_hover ?? '#0056b3') }}" 
                                                   onchange="document.getElementById('button_primary_hover').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link_color" class="form-label">Warna Link</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="link_color" name="link_color" 
                                                   value="{{ old('link_color', $siteSetting->link_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('link_color', $siteSetting->link_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('link_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Button Colors -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Warna Tombol di Card</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card_button_bg" class="form-label">Background Tombol</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_bg" name="card_button_bg" 
                                                   value="{{ old('card_button_bg', $siteSetting->card_button_bg ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_bg', $siteSetting->card_button_bg ?? '#007bff') }}" 
                                                   onchange="document.getElementById('card_button_bg').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="card_button_text" class="form-label">Teks Tombol</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_text" name="card_button_text" 
                                                   value="{{ old('card_button_text', $siteSetting->card_button_text ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_text', $siteSetting->card_button_text ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('card_button_text').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="card_button_border" class="form-label">Border Tombol</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_border" name="card_button_border" 
                                                   value="{{ old('card_button_border', $siteSetting->card_button_border ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_border', $siteSetting->card_button_border ?? '#007bff') }}" 
                                                   onchange="document.getElementById('card_button_border').value = this.value">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card_button_hover_bg" class="form-label">Background Hover</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_hover_bg" name="card_button_hover_bg" 
                                                   value="{{ old('card_button_hover_bg', $siteSetting->card_button_hover_bg ?? '#0056b3') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_hover_bg', $siteSetting->card_button_hover_bg ?? '#0056b3') }}" 
                                                   onchange="document.getElementById('card_button_hover_bg').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="card_button_hover_text" class="form-label">Teks Hover</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_hover_text" name="card_button_hover_text" 
                                                   value="{{ old('card_button_hover_text', $siteSetting->card_button_hover_text ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_hover_text', $siteSetting->card_button_hover_text ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('card_button_hover_text').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="card_button_hover_border" class="form-label">Border Hover</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="card_button_hover_border" name="card_button_hover_border" 
                                                   value="{{ old('card_button_hover_border', $siteSetting->card_button_hover_border ?? '#0056b3') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('card_button_hover_border', $siteSetting->card_button_hover_border ?? '#0056b3') }}" 
                                                   onchange="document.getElementById('card_button_hover_border').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Transparency Settings -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Pengaturan Transparansi Website</h6>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="navbar_transparency" class="form-label">Transparansi Navbar (%)</label>
                                        <input type="range" class="form-range" id="navbar_transparency" name="navbar_transparency" 
                                               min="0" max="100" value="{{ old('navbar_transparency', $siteSetting->navbar_transparency ?? 100) }}"
                                               oninput="document.getElementById('navbar_transparency_value').textContent = this.value + '%'">
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">0% (Transparan)</small>
                                            <span id="navbar_transparency_value" class="badge bg-primary">{{ old('navbar_transparency', $siteSetting->navbar_transparency ?? 100) }}%</span>
                                            <small class="text-muted">100% (Solid)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="header_transparency" class="form-label">Transparansi Header (%)</label>
                                        <input type="range" class="form-range" id="header_transparency" name="header_transparency" 
                                               min="0" max="100" value="{{ old('header_transparency', $siteSetting->header_transparency ?? 100) }}"
                                               oninput="document.getElementById('header_transparency_value').textContent = this.value + '%'">
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">0% (Transparan)</small>
                                            <span id="header_transparency_value" class="badge bg-primary">{{ old('header_transparency', $siteSetting->header_transparency ?? 100) }}%</span>
                                            <small class="text-muted">100% (Solid)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="footer_transparency" class="form-label">Transparansi Footer (%)</label>
                                        <input type="range" class="form-range" id="footer_transparency" name="footer_transparency" 
                                               min="0" max="100" value="{{ old('footer_transparency', $siteSetting->footer_transparency ?? 100) }}"
                                               oninput="document.getElementById('footer_transparency_value').textContent = this.value + '%'">
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">0% (Transparan)</small>
                                            <span id="footer_transparency_value" class="badge bg-primary">{{ old('footer_transparency', $siteSetting->footer_transparency ?? 100) }}%</span>
                                            <small class="text-muted">100% (Solid)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="enable_blur_effect" name="enable_blur_effect" 
                                               value="1" {{ old('enable_blur_effect', $siteSetting->enable_blur_effect ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_blur_effect">
                                            <i class="bi bi-eye"></i> Aktifkan Efek Blur untuk Elemen Transparan
                                        </label>
                                        <small class="form-text text-muted d-block">Menambahkan efek blur pada elemen yang memiliki transparansi</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Detailed Color Settings -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Pengaturan Warna Detail</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="section_bg_color" class="form-label">Background Section</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="section_bg_color" name="section_bg_color" 
                                                   value="{{ old('section_bg_color', $siteSetting->section_bg_color ?? '#f8f9fa') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('section_bg_color', $siteSetting->section_bg_color ?? '#f8f9fa') }}" 
                                                   onchange="document.getElementById('section_bg_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="section_text_color" class="form-label">Teks Section</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="section_text_color" name="section_text_color" 
                                                   value="{{ old('section_text_color', $siteSetting->section_text_color ?? '#333333') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('section_text_color', $siteSetting->section_text_color ?? '#333333') }}" 
                                                   onchange="document.getElementById('section_text_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="button_text_color" class="form-label">Teks Tombol</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="button_text_color" name="button_text_color" 
                                                   value="{{ old('button_text_color', $siteSetting->button_text_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('button_text_color', $siteSetting->button_text_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('button_text_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="button_outline_color" class="form-label">Border Tombol</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="button_outline_color" name="button_outline_color" 
                                                   value="{{ old('button_outline_color', $siteSetting->button_outline_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('button_outline_color', $siteSetting->button_outline_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('button_outline_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link_text_color" class="form-label">Warna Link</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="link_text_color" name="link_text_color" 
                                                   value="{{ old('link_text_color', $siteSetting->link_text_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('link_text_color', $siteSetting->link_text_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('link_text_color').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="badge_bg_color" class="form-label">Background Badge</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="badge_bg_color" name="badge_bg_color" 
                                                   value="{{ old('badge_bg_color', $siteSetting->badge_bg_color ?? '#007bff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('badge_bg_color', $siteSetting->badge_bg_color ?? '#007bff') }}" 
                                                   onchange="document.getElementById('badge_bg_color').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Footer Colors Section -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">Pengaturan Warna Footer</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="footer_bg_color" class="form-label">Background Footer</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_bg_color" name="footer_bg_color" 
                                                       value="{{ old('footer_bg_color', $siteSetting->footer_bg_color ?? '#343a40') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_bg_color', $siteSetting->footer_bg_color ?? '#343a40') }}" 
                                                       onchange="document.getElementById('footer_bg_color').value = this.value">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="footer_text_color" class="form-label">Warna Teks Footer</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_text_color" name="footer_text_color" 
                                                       value="{{ old('footer_text_color', $siteSetting->footer_text_color ?? '#ffffff') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_text_color', $siteSetting->footer_text_color ?? '#ffffff') }}" 
                                                       onchange="document.getElementById('footer_text_color').value = this.value">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="footer_link_color" class="form-label">Warna Link Footer</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_link_color" name="footer_link_color" 
                                                       value="{{ old('footer_link_color', $siteSetting->footer_link_color ?? '#ffffff') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_link_color', $siteSetting->footer_link_color ?? '#ffffff') }}" 
                                                       onchange="document.getElementById('footer_link_color').value = this.value">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="footer_link_hover_color" class="form-label">Warna Link Hover</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_link_hover_color" name="footer_link_hover_color" 
                                                       value="{{ old('footer_link_hover_color', $siteSetting->footer_link_hover_color ?? '#007bff') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_link_hover_color', $siteSetting->footer_link_hover_color ?? '#007bff') }}" 
                                                       onchange="document.getElementById('footer_link_hover_color').value = this.value">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="footer_border_color" class="form-label">Warna Border Footer</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_border_color" name="footer_border_color" 
                                                       value="{{ old('footer_border_color', $siteSetting->footer_border_color ?? '#333333') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_border_color', $siteSetting->footer_border_color ?? '#333333') }}" 
                                                       onchange="document.getElementById('footer_border_color').value = this.value">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="footer_social_bg_color" class="form-label">Background Social Media</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_social_bg_color" name="footer_social_bg_color" 
                                                       value="{{ old('footer_social_bg_color', $siteSetting->footer_social_bg_color ?? '#333333') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_social_bg_color', $siteSetting->footer_social_bg_color ?? '#333333') }}" 
                                                       onchange="document.getElementById('footer_social_bg_color').value = this.value">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="footer_social_hover_color" class="form-label">Warna Social Media Hover</label>
                                            <div class="input-group">
                                                <input type="color" class="form-control form-control-color" 
                                                       id="footer_social_hover_color" name="footer_social_hover_color" 
                                                       value="{{ old('footer_social_hover_color', $siteSetting->footer_social_hover_color ?? '#007bff') }}">
                                                <input type="text" class="form-control" 
                                                       value="{{ old('footer_social_hover_color', $siteSetting->footer_social_hover_color ?? '#007bff') }}" 
                                                       onchange="document.getElementById('footer_social_hover_color').value = this.value">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Admin Colors Tab -->
                        <div class="tab-pane fade" id="admin-colors" role="tabpanel">
                            <h6 class="mb-3">Pengaturan Warna Admin Panel</h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Sidebar Admin</h6>
                                    <div class="mb-3">
                                        <label for="admin_sidebar_bg" class="form-label">Background Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="admin_sidebar_bg" name="admin_sidebar_bg" 
                                                   value="{{ old('admin_sidebar_bg', $siteSetting->admin_sidebar_bg ?? '#343a40') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('admin_sidebar_bg', $siteSetting->admin_sidebar_bg ?? '#343a40') }}" 
                                                   onchange="document.getElementById('admin_sidebar_bg').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="admin_sidebar_text" class="form-label">Teks Sidebar</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="admin_sidebar_text" name="admin_sidebar_text" 
                                                   value="{{ old('admin_sidebar_text', $siteSetting->admin_sidebar_text ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('admin_sidebar_text', $siteSetting->admin_sidebar_text ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('admin_sidebar_text').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="admin_sidebar_hover" class="form-label">Sidebar Hover</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="admin_sidebar_hover" name="admin_sidebar_hover" 
                                                   value="{{ old('admin_sidebar_hover', $siteSetting->admin_sidebar_hover ?? '#495057') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('admin_sidebar_hover', $siteSetting->admin_sidebar_hover ?? '#495057') }}" 
                                                   onchange="document.getElementById('admin_sidebar_hover').value = this.value">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Header Admin</h6>
                                    <div class="mb-3">
                                        <label for="admin_header_bg" class="form-label">Background Header</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="admin_header_bg" name="admin_header_bg" 
                                                   value="{{ old('admin_header_bg', $siteSetting->admin_header_bg ?? '#ffffff') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('admin_header_bg', $siteSetting->admin_header_bg ?? '#ffffff') }}" 
                                                   onchange="document.getElementById('admin_header_bg').value = this.value">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="admin_header_text" class="form-label">Teks Header</label>
                                        <div class="input-group">
                                            <input type="color" class="form-control form-control-color" 
                                                   id="admin_header_text" name="admin_header_text" 
                                                   value="{{ old('admin_header_text', $siteSetting->admin_header_text ?? '#333333') }}">
                                            <input type="text" class="form-control" 
                                                   value="{{ old('admin_header_text', $siteSetting->admin_header_text ?? '#333333') }}" 
                                                   onchange="document.getElementById('admin_header_text').value = this.value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ubah Password Tab (form terpisah via form="password-form") -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <h6 class="mb-3"><i class="bi bi-key"></i> Ubah Password Admin</h6>
                            <p class="text-muted small mb-4">Gunakan form di bawah untuk mengubah password akun Anda. Password baru minimal 8 karakter.</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password" form="password-form" required autocomplete="current-password"
                                               placeholder="Masukkan password saat ini">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" name="new_password" form="password-form" required minlength="8" autocomplete="new-password"
                                               placeholder="Minimal 8 karakter">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password_confirmation" 
                                               name="new_password_confirmation" form="password-form" required minlength="8" autocomplete="new-password"
                                               placeholder="Ulangi password baru">
                                    </div>
                                    <button type="submit" form="password-form" class="btn btn-primary">
                                        <i class="bi bi-key-fill"></i> Simpan Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary" id="save-settings-btn">
                            <i class="bi bi-save"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>

                <!-- Form ubah password (terpisah, inputs di tab pakai form="password-form") -->
                <form id="password-form" action="{{ route('admin.change-password') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aktifkan tab Ubah Password jika redirect dari form ubah password
    @if(session('active_tab') === 'password')
    (function() {
        const passwordTab = document.querySelector('#password-tab');
        const passwordPane = document.querySelector('#password');
        if (passwordTab && passwordPane) {
            const tab = new bootstrap.Tab(passwordTab);
            tab.show();
        }
    })();
    @endif

    // Sync color picker with text input
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(function(colorInput) {
        if (colorInput && colorInput.parentElement) {
            // Find the text input in the same input-group
            const inputGroup = colorInput.parentElement;
            const textInput = inputGroup.querySelector('input[type="text"]');
            
            if (textInput) {
                colorInput.addEventListener('change', function() {
                    if (textInput) {
                        textInput.value = this.value;
                        // Color picker changed
                    }
                });
                
                textInput.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-F]{6}$/i) && colorInput) {
                        colorInput.value = this.value;
                        // Text input changed
                    }
                });
            } else {
                // Console log removed
            }
        }
    });
    
    // Function to apply colors with visual feedback
    function applyColors(colors) {
        let appliedCount = 0;
        try {
            Object.keys(colors).forEach(function(key) {
                const colorInput = document.getElementById(key);
                if (colorInput && colorInput.parentElement) {
                    // Find the text input in the same input-group
                    const inputGroup = colorInput.parentElement;
                    const textInput = inputGroup.querySelector('input[type="text"]');
                    
                    if (textInput) {
                        // Add visual feedback
                        colorInput.style.border = '2px solid #28a745';
                        textInput.style.border = '2px solid #28a745';
                        
                        colorInput.value = colors[key];
                        textInput.value = colors[key];
                        appliedCount++;
                        
                        // Trigger events safely
                        try {
                            colorInput.dispatchEvent(new Event('change', { bubbles: true }));
                            textInput.dispatchEvent(new Event('input', { bubbles: true }));
                        } catch (e) {
                            // Console log removed
                        }
                        
                        // Remove visual feedback after a short delay
                        setTimeout(() => {
                            if (colorInput && colorInput.style) {
                                colorInput.style.border = '';
                            }
                            if (textInput && textInput.style) {
                                textInput.style.border = '';
                            }
                        }, 1000);
                        
                        // Console log removed
                    } else {
                        // Console log removed
                    }
                } else {
                    // Console log removed
                }
            });
        } catch (e) {
            console.error('Error in applyColors:', e.message);
        }
        return appliedCount;
    }
    
    // Theme presets
    const presets = {
        default: {
            primary_color: '#007bff',
            secondary_color: '#6c757d',
            accent_color: '#28a745',
            header_bg_color: '#ffffff',
            footer_bg_color: '#343a40',
            body_bg_color: '#f8f9fa',
            header_text_color: '#000000',
            footer_text_color: '#ffffff',
            body_text_color: '#333333',
            button_primary_color: '#007bff',
            button_primary_hover: '#0056b3',
            button_secondary_color: '#6c757d',
            button_secondary_hover: '#545b62',
            link_color: '#007bff',
            link_hover_color: '#0056b3',
            card_bg_color: '#ffffff',
            card_border_color: '#dee2e6',
            card_shadow_color: '#000000',
            admin_sidebar_bg: '#343a40',
            admin_sidebar_text: '#ffffff',
            admin_sidebar_hover: '#495057',
            admin_header_bg: '#ffffff',
            admin_header_text: '#333333'
        },
        green: {
            primary_color: '#28a745',
            secondary_color: '#6c757d',
            accent_color: '#20c997',
            header_bg_color: '#ffffff',
            footer_bg_color: '#155724',
            body_bg_color: '#f8fff9',
            header_text_color: '#000000',
            footer_text_color: '#ffffff',
            body_text_color: '#333333',
            button_primary_color: '#28a745',
            button_primary_hover: '#1e7e34',
            button_secondary_color: '#6c757d',
            button_secondary_hover: '#545b62',
            link_color: '#28a745',
            link_hover_color: '#1e7e34',
            card_bg_color: '#ffffff',
            card_border_color: '#d4edda',
            card_shadow_color: '#000000',
            admin_sidebar_bg: '#155724',
            admin_sidebar_text: '#ffffff',
            admin_sidebar_hover: '#0d4f1c',
            admin_header_bg: '#ffffff',
            admin_header_text: '#333333'
        },
        red: {
            primary_color: '#dc3545',
            secondary_color: '#6c757d',
            accent_color: '#fd7e14',
            header_bg_color: '#ffffff',
            footer_bg_color: '#721c24',
            body_bg_color: '#fff8f8',
            header_text_color: '#000000',
            footer_text_color: '#ffffff',
            body_text_color: '#333333',
            button_primary_color: '#dc3545',
            button_primary_hover: '#c82333',
            button_secondary_color: '#6c757d',
            button_secondary_hover: '#545b62',
            link_color: '#dc3545',
            link_hover_color: '#c82333',
            card_bg_color: '#ffffff',
            card_border_color: '#f5c6cb',
            card_shadow_color: '#000000',
            admin_sidebar_bg: '#721c24',
            admin_sidebar_text: '#ffffff',
            admin_sidebar_hover: '#5a1519',
            admin_header_bg: '#ffffff',
            admin_header_text: '#333333'
        },
        orange: {
            primary_color: '#fd7e14',
            secondary_color: '#6c757d',
            accent_color: '#ffc107',
            header_bg_color: '#ffffff',
            footer_bg_color: '#856404',
            body_bg_color: '#fff8f0',
            header_text_color: '#000000',
            footer_text_color: '#ffffff',
            body_text_color: '#333333',
            button_primary_color: '#fd7e14',
            button_primary_hover: '#e55a00',
            button_secondary_color: '#6c757d',
            button_secondary_hover: '#545b62',
            link_color: '#fd7e14',
            link_hover_color: '#e55a00',
            card_bg_color: '#ffffff',
            card_border_color: '#ffeaa7',
            card_shadow_color: '#000000',
            admin_sidebar_bg: '#856404',
            admin_sidebar_text: '#ffffff',
            admin_sidebar_hover: '#6b5204',
            admin_header_bg: '#ffffff',
            admin_header_text: '#333333'
        }
    };
    
    // Wait for DOM to be fully loaded
    setTimeout(function() {
        const presetButtons = document.querySelectorAll('.preset-btn');
        // Console log removed
        
        if (presetButtons.length > 0) {
            presetButtons.forEach(function(btn, index) {
                if (btn) {
                    // Console log removed
                    
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const preset = this.dataset.preset;
                        const colors = presets[preset];
                        
                        // Console log removed
                        
                        const appliedCount = applyColors(colors);
                        
                        // Show feedback
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="bi bi-check-circle"></i><br><small>Applied!</small>';
                        this.classList.add('btn-success');
                        this.classList.remove('btn-outline-primary', 'btn-outline-success', 'btn-outline-danger', 'btn-outline-warning');
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('btn-success');
                            if (preset === 'default') {
                                this.classList.add('btn-outline-primary');
                            } else if (preset === 'green') {
                                this.classList.add('btn-outline-success');
                            } else if (preset === 'red') {
                                this.classList.add('btn-outline-danger');
                            } else if (preset === 'orange') {
                                this.classList.add('btn-outline-warning');
                            }
                        }, 2000);
                        
                        // Console log removed
                    });
                }
            });
        } else {
            // Console log removed
        }
    }, 100);
    
    // Form submission debugging
    const form = document.querySelector('form');
    if (form) {
        // Console log removed
        // Console log removed
        // Console log removed
        
        form.addEventListener('submit', function(e) {
            // Console log removed
            // Console log removed
            
            // Check if any color fields have values
            const colorInputs = document.querySelectorAll('input[type="color"]');
            let hasColors = false;
            let colorCount = 0;
            
            // Console log removed
            
            colorInputs.forEach(function(input) {
                if (input && input.value) {
                    hasColors = true;
                    colorCount++;
                    // Console log removed
                }
            });
            
            // Console log removed
            
            if (!hasColors) {
                // Console log removed
                alert('Warning: No color values detected. Make sure to select a preset or manually set colors before saving.');
            } else {
                // Console log removed
            }
            
            // Don't prevent default submission
            // e.preventDefault(); // Commented out to allow normal form submission
        });
    } else {
        // Console log removed
    }
    
    // Test function for debugging
    window.testPreset = function() {
        // Console log removed
        const testColors = {
            primary_color: '#ff0000',
            secondary_color: '#00ff00',
            accent_color: '#0000ff'
        };
        
        const appliedCount = applyColors(testColors);
        // Console log removed
        
        // Show alert
        alert('Test preset applied! Check console for details. Applied ' + appliedCount + ' colors.');
    };
    
    // Test Orange preset specifically
    window.testOrangePreset = function() {
        // Console log removed
        // Console log removed
        const orangeColors = presets.orange;
        const appliedCount = applyColors(orangeColors);
        // Console log removed
        
        // Show alert
        alert('Orange preset applied! Check console for details. Applied ' + appliedCount + ' colors.');
        
        // Auto-submit form after 2 seconds
        setTimeout(function() {
            // Console log removed
            const form = document.querySelector('form');
            if (form) {
                form.submit();
            }
        }, 2000);
    };
    
    // Reset theme function
    window.resetTheme = function() {
        if (confirm('Apakah Anda yakin ingin mereset tema ke pengaturan default?')) {
            // Console log removed
            const defaultColors = presets.default;
            const appliedCount = applyColors(defaultColors);
            // Console log removed
            
            // Show success message
            alert('Tema berhasil direset ke pengaturan default! Applied ' + appliedCount + ' colors.');
        }
    };
    
    // Make sure testPreset is available globally
    // Console log removed
    
    // Add event listener for test button
    const testBtn = document.getElementById('testPresetBtn');
    if (testBtn) {
        testBtn.addEventListener('click', function() {
            window.testPreset();
        });
    }
});
</script>
@endpush