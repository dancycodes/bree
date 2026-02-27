@extends('layouts.admin')

@section('title', 'Photos — ' . $album->title_fr . ' — Galerie')
@section('page_title', 'Photos de l\'album')
@section('breadcrumb', 'Galerie › Albums › ' . $album->title_fr . ' › Photos')

@section('content')

    <div x-data="photosManager({
        photos: {{ Js::from($photoData) }},
        uploadUrl: {{ Js::from(route('admin.gallery.albums.photos.store', $album)) }},
        reorderUrl: {{ Js::from(route('admin.gallery.albums.photos.reorder', $album)) }},
        csrfToken: {{ Js::from(csrf_token()) }}
    })">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main (2/3) --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Upload zone --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: #94a3b8;">
                        Ajouter des photos
                    </h3>

                    {{-- Drop zone --}}
                    <div
                        class="rounded-xl flex flex-col items-center justify-center gap-3 p-8 cursor-pointer transition-colors"
                        :style="dragover
                            ? 'border: 2px dashed #c80078; background-color: #fdf4fb;'
                            : 'border: 2px dashed #e2e8f0; background-color: #fafafa;'"
                        @dragover.prevent="dragover = true"
                        @dragleave="dragover = false"
                        @drop="onDrop($event)"
                        @click="$refs.fileInput.click()">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.25"
                             style="color: #cbd5e1;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                        </svg>
                        <div class="text-center">
                            <p class="text-sm font-medium" style="color: #475569;">
                                Glissez vos photos ici ou <span style="color: #c80078;">cliquez pour sélectionner</span>
                            </p>
                            <p class="text-xs mt-1" style="color: #94a3b8;">JPEG, PNG, WebP — max 5 MB par photo</p>
                        </div>
                    </div>

                    {{-- Hidden file input --}}
                    <input
                        type="file"
                        x-ref="fileInput"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        multiple
                        class="hidden"
                        @change="onFilesSelected($event)">

                    {{-- Pending files list --}}
                    <div x-show="pendingFiles.length > 0" class="mt-4 space-y-2">
                        <template x-for="(f, i) in pendingFiles" :key="i">
                            <div class="flex items-center gap-3 p-3 rounded-xl" style="background-color: #f8fafc;">
                                {{-- Preview or icon --}}
                                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center"
                                     style="background-color: #e2e8f0;">
                                    <template x-if="f.preview">
                                        <img :src="f.preview" class="w-full h-full object-cover" alt="">
                                    </template>
                                    <template x-if="!f.preview">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                                             style="color: #94a3b8;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 18.75V7.5A2.25 2.25 0 015.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75z"/>
                                        </svg>
                                    </template>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium truncate" style="color: #1e293b;" x-text="f.name"></p>
                                    {{-- Progress bar --}}
                                    <template x-if="f.status === 'uploading' || f.status === 'done'">
                                        <div class="mt-1.5 h-1.5 rounded-full overflow-hidden" style="background-color: #e2e8f0;">
                                            <div class="h-full rounded-full transition-all duration-300"
                                                 :style="`width:${f.progress}%; background-color:${f.status === 'done' ? '#16a34a' : '#c80078'}`">
                                            </div>
                                        </div>
                                    </template>
                                    {{-- Error message --}}
                                    <template x-if="f.status === 'error'">
                                        <p class="text-xs mt-1" style="color: #ef4444;" x-text="f.error"></p>
                                    </template>
                                    {{-- Pending label --}}
                                    <template x-if="f.status === 'pending'">
                                        <p class="text-xs mt-1" style="color: #94a3b8;">En attente…</p>
                                    </template>
                                </div>

                                {{-- Status icon / remove button --}}
                                <div class="flex-shrink-0">
                                    <template x-if="f.status === 'done'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                             style="color: #16a34a;">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </template>
                                    <template x-if="f.status !== 'done' && f.status !== 'uploading'">
                                        <button @click.stop="removePending(i)" class="p-1 rounded hover:bg-slate-100 transition-colors"
                                                style="color: #94a3b8;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Upload button --}}
                    <div x-show="pendingFiles.some(f => f.status === 'pending')" class="mt-4">
                        <button
                            @click="uploadAll()"
                            :disabled="uploading"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
                            style="background-color: #c80078;">
                            <span x-show="!uploading">
                                Télécharger
                                <span x-text="pendingFiles.filter(f => f.status === 'pending').length"></span>
                                photo(s)
                            </span>
                            <span x-show="uploading">Téléchargement en cours…</span>
                        </button>
                    </div>
                </div>

                {{-- Photos grid --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-semibold uppercase tracking-wider" style="color: #94a3b8;">
                            Photos (<span x-text="photos.length"></span>)
                        </h3>
                        <p x-show="photos.length > 1" class="text-xs" style="color: #94a3b8;">
                            Glissez pour réordonner
                        </p>
                    </div>

                    <div x-show="photos.length === 0" class="py-10 text-center">
                        <p class="text-sm" style="color: #94a3b8;">Aucune photo dans cet album.</p>
                    </div>

                    <div x-show="photos.length > 0"
                         class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        <template x-for="(photo, i) in photos" :key="photo.id">
                            <div
                                :id="'photo-' + photo.id"
                                draggable="true"
                                @dragstart="dragStart(i)"
                                @dragenter.prevent="dragEnter(i)"
                                @dragover.prevent
                                @dragend="dragEnd()"
                                class="group relative rounded-xl overflow-hidden cursor-grab active:cursor-grabbing"
                                :class="dragSrcIdx === i ? 'opacity-50 ring-2' : ''"
                                style="aspect-ratio: 1; background-color: #f1f5f9;">

                                {{-- Thumbnail --}}
                                <img :src="photo.url" :alt="photo.caption_fr || ''"
                                     class="w-full h-full object-cover select-none">

                                {{-- Overlay on hover --}}
                                <div class="absolute inset-0 flex flex-col justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                     style="background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, transparent 40%, transparent 60%, rgba(0,0,0,0.5) 100%);">
                                    {{-- Top: delete --}}
                                    <div class="flex justify-end">
                                        <button
                                            @click.stop="$action.delete(photo.delete_url)"
                                            class="w-6 h-6 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors"
                                            style="background-color: rgba(0,0,0,0.5);"
                                            title="Supprimer">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Bottom: caption + edit --}}
                                    <div class="flex items-end justify-between gap-1">
                                        <p class="text-white text-xs leading-tight truncate flex-1"
                                           x-text="photo.caption_fr || 'Ajouter une légende…'"
                                           :style="photo.caption_fr ? 'opacity:1' : 'opacity:0.6'"></p>
                                        <button
                                            @click.stop="startEdit(photo)"
                                            class="w-6 h-6 rounded flex items-center justify-center flex-shrink-0 transition-colors"
                                            style="background-color: rgba(255,255,255,0.2);"
                                            title="Modifier la légende">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Sort order badge --}}
                                <div class="absolute top-1.5 left-1.5 w-5 h-5 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                     style="background-color: rgba(0,0,0,0.5);"
                                     x-text="i + 1">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            {{-- Sidebar (1/3) --}}
            <div class="space-y-5">

                {{-- Album info --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Album</h3>
                    @if ($album->cover_photo_path)
                        <div class="rounded-xl overflow-hidden mb-3" style="height: 100px;">
                            <img src="{{ vasset($album->cover_photo_path) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <p class="text-sm font-semibold" style="color: #1e293b;">{{ $album->title_fr }}</p>
                    <p class="text-xs font-mono mt-1" style="color: #94a3b8;">{{ $album->slug }}</p>
                    <div class="mt-2">
                        @if ($album->is_published)
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                  style="background-color: #dcfce7; color: #16a34a;">Publié</span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                  style="background-color: #f1f5f9; color: #64748b;">Brouillon</span>
                        @endif
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 space-y-1">
                    <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: #94a3b8;">Navigation</h3>
                    <a href="{{ route('admin.gallery.albums.edit', $album) }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-slate-50"
                       style="color: #475569;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                        Modifier l'album
                    </a>
                    <a href="{{ route('admin.gallery.albums.index') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-slate-50"
                       style="color: #475569;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Tous les albums
                    </a>
                    @if ($album->is_published)
                        <a href="{{ route('public.gallery.show', $album) }}" target="_blank"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-slate-50"
                           style="color: #475569;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Voir en ligne
                        </a>
                    @endif
                </div>

                {{-- Tips --}}
                <div class="rounded-2xl p-5" style="background-color: #fffbeb; border: 1px solid #fde68a;">
                    <p class="text-xs font-semibold mb-2" style="color: #92400e;">Conseils</p>
                    <ul class="space-y-1.5 text-xs" style="color: #78350f;">
                        <li>• Glissez les vignettes pour réordonner</li>
                        <li>• L'ordre ici détermine l'ordre dans la galerie publique</li>
                        <li>• Survolez une photo pour ajouter une légende</li>
                        <li>• Les légendes s'affichent dans le lightbox</li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Caption Edit Modal --}}
        <div
            :style="`display:${editingId !== null ? 'flex' : 'none'}`"
            class="fixed inset-0 z-50 items-center justify-center p-4"
            style="display: none; background-color: rgba(0,0,0,0.5);"
            @click.self="cancelEdit()">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-sm font-semibold" style="color: #1e293b;">Légende de la photo</h3>
                    <button @click="cancelEdit()" style="color: #94a3b8;" class="hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                            Légende (FR)
                        </label>
                        <input
                            x-model="editFr"
                            type="text"
                            maxlength="500"
                            placeholder="Légende en français…"
                            class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                            style="border-color: #e2e8f0; color: #1e293b;"
                            @keydown.enter="saveCaption(photos.find(p => p.id === editingId))"
                            @keydown.escape="cancelEdit()">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1.5" style="color: #475569;">
                            Caption (EN)
                        </label>
                        <input
                            x-model="editEn"
                            type="text"
                            maxlength="500"
                            placeholder="Caption in English…"
                            class="w-full text-sm px-3 py-2.5 rounded-lg border focus:outline-none"
                            style="border-color: #e2e8f0; color: #1e293b;"
                            @keydown.enter="saveCaption(photos.find(p => p.id === editingId))"
                            @keydown.escape="cancelEdit()">
                    </div>
                </div>

                <div class="flex gap-2 mt-5">
                    <button
                        @click="saveCaption(photos.find(p => p.id === editingId))"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                        style="background-color: #c80078;">
                        Sauvegarder
                    </button>
                    <button
                        @click="cancelEdit()"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors hover:bg-slate-100"
                        style="color: #64748b;">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('photosManager', (config) => ({
        photos: config.photos,
        uploadUrl: config.uploadUrl,
        reorderUrl: config.reorderUrl,
        csrfToken: config.csrfToken,
        pendingFiles: [],
        dragover: false,
        uploading: false,
        editingId: null,
        editFr: '',
        editEn: '',
        dragSrcIdx: null,

        onFilesSelected(event) {
            const files = Array.from(event.target.files);
            this._addFiles(files);
            event.target.value = '';
        },

        onDrop(event) {
            event.preventDefault();
            this.dragover = false;
            if (this.dragSrcIdx !== null) { return; }
            const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            this._addFiles(files);
        },

        _addFiles(files) {
            files.forEach(file => {
                if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
                    this.pendingFiles.push({ file: null, name: file.name, preview: null, progress: 0, status: 'error', error: 'Format non accepté (JPEG, PNG, WebP uniquement)' });
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    this.pendingFiles.push({ file: null, name: file.name, preview: null, progress: 0, status: 'error', error: 'Cette photo dépasse la taille maximale de 5 MB' });
                    return;
                }
                this.pendingFiles.push({
                    file,
                    name: file.name,
                    preview: URL.createObjectURL(file),
                    progress: 0,
                    status: 'pending',
                    error: null,
                });
            });
        },

        async uploadAll() {
            if (this.uploading) { return; }
            const hasPending = this.pendingFiles.some(f => f.status === 'pending');
            if (!hasPending) { return; }
            this.uploading = true;

            for (let i = 0; i < this.pendingFiles.length; i++) {
                if (this.pendingFiles[i].status !== 'pending') { continue; }
                this.pendingFiles[i].status = 'uploading';
                try {
                    const result = await this._uploadSingle(this.pendingFiles[i], i);
                    this.pendingFiles[i].status = 'done';
                    this.pendingFiles[i].progress = 100;
                    this.photos.push(result);
                } catch (err) {
                    this.pendingFiles[i].status = 'error';
                    this.pendingFiles[i].error = typeof err === 'string' ? err : 'Erreur lors du téléchargement';
                }
            }

            const doneCount = this.pendingFiles.filter(f => f.status === 'done').length;
            this.pendingFiles = this.pendingFiles.filter(f => f.status !== 'done');
            this.uploading = false;

            if (doneCount > 0) {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: doneCount + ' photo(s) ajoutée(s)', type: 'success' }
                }));
            }
        },

        _uploadSingle(f, index) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                const formData = new FormData();
                formData.append('photo', f.file);
                formData.append('_token', this.csrfToken);

                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        this.pendingFiles[index].progress = Math.round(e.loaded / e.total * 100);
                    }
                });

                xhr.addEventListener('load', () => {
                    if (xhr.status === 200) {
                        resolve(JSON.parse(xhr.responseText));
                    } else {
                        try {
                            const err = JSON.parse(xhr.responseText);
                            const msg = err.errors?.photo?.[0] || err.message || 'Erreur lors du téléchargement';
                            reject(msg);
                        } catch {
                            reject('Erreur lors du téléchargement');
                        }
                    }
                });

                xhr.addEventListener('error', () => reject('Erreur réseau'));
                xhr.open('POST', this.uploadUrl);
                xhr.send(formData);
            });
        },

        removePending(index) {
            this.pendingFiles.splice(index, 1);
        },

        startEdit(photo) {
            this.editingId = photo.id;
            this.editFr = photo.caption_fr || '';
            this.editEn = photo.caption_en || '';
        },

        async saveCaption(photo) {
            if (!photo) { return; }
            try {
                const response = await fetch(photo.update_url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: JSON.stringify({ caption_fr: this.editFr, caption_en: this.editEn }),
                });
                if (response.ok) {
                    const data = await response.json();
                    photo.caption_fr = data.caption_fr;
                    photo.caption_en = data.caption_en;
                    this.editingId = null;
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { message: 'Légende sauvegardée', type: 'success' }
                    }));
                }
            } catch {
                // silent — network error
            }
        },

        cancelEdit() {
            this.editingId = null;
        },

        dragStart(index) {
            this.dragSrcIdx = index;
        },

        dragEnter(index) {
            if (this.dragSrcIdx === null || this.dragSrcIdx === index) { return; }
            const arr = [...this.photos];
            const [moved] = arr.splice(this.dragSrcIdx, 1);
            arr.splice(index, 0, moved);
            this.photos = arr;
            this.dragSrcIdx = index;
        },

        async dragEnd() {
            if (this.dragSrcIdx === null) { return; }
            this.dragSrcIdx = null;
            await this._saveOrder();
        },

        async _saveOrder() {
            const order = this.photos.map(p => p.id);
            try {
                const response = await fetch(this.reorderUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: JSON.stringify({ order }),
                });
                if (response.ok) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { message: 'Ordre sauvegardé', type: 'success' }
                    }));
                }
            } catch {
                // silent — order will re-sync on next page load
            }
        },
    }));
});
</script>
@endpush
