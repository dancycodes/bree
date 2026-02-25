{{-- Name --}}
<div>
    <label class="block text-sm font-semibold mb-2" style="color: #475569;">
        Nom de l'organisation <span style="color: #ef4444;">*</span>
    </label>
    <input type="text" name="name"
           value="{{ old('name', $partner?->name) }}"
           placeholder="Ex: UNICEF Cameroun"
           class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none @error('name') border-red-400 @else border-slate-200 @enderror"
           style="color: #1e293b;">
    @error('name')
        <p class="text-xs mt-1.5" style="color: #ef4444;">{{ $message }}</p>
    @enderror
</div>

{{-- Type --}}
<div>
    <label class="block text-sm font-semibold mb-2" style="color: #475569;">
        Type de partenariat <span style="color: #ef4444;">*</span>
    </label>
    <select name="type"
            class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none @error('type') border-red-400 @else border-slate-200 @enderror"
            style="color: #1e293b; background-color: #ffffff;">
        <option value="">— Choisir un type —</option>
        @foreach (['institutional' => 'Institutionnel', 'financial' => 'Financier', 'technical' => 'Technique'] as $val => $label)
            <option value="{{ $val }}" {{ old('type', $partner?->type) === $val ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('type')
        <p class="text-xs mt-1.5" style="color: #ef4444;">{{ $message }}</p>
    @enderror
</div>

{{-- Logo --}}
<div>
    <label class="block text-sm font-semibold mb-2" style="color: #475569;">
        Logo
    </label>
    @if ($partner?->logo_path)
        <div class="flex items-center gap-4 mb-3 p-3 rounded-xl" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
            <img src="{{ asset($partner->logo_path) }}" alt=""
                 class="w-16 h-12 object-contain rounded-lg" style="background: #fff;">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium" style="color: #475569;">Logo actuel</p>
                <label class="flex items-center gap-2 mt-1 cursor-pointer">
                    <input type="checkbox" name="remove_logo" value="1" class="rounded">
                    <span class="text-xs" style="color: #ef4444;">Supprimer ce logo</span>
                </label>
            </div>
        </div>
    @endif
    <input type="file" name="logo" accept="image/*"
           class="w-full text-sm px-4 py-2.5 rounded-xl border focus:outline-none"
           style="border-color: #e2e8f0; color: #475569;">
    <p class="text-xs mt-1.5" style="color: #94a3b8;">JPEG, PNG, WebP ou SVG — max 2 Mo</p>
    @error('logo')
        <p class="text-xs mt-1.5" style="color: #ef4444;">{{ $message }}</p>
    @enderror
</div>

{{-- Description FR / EN --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-2" style="color: #475569;">
            Description (FR)
        </label>
        <textarea name="description_fr" rows="4"
                  placeholder="Description en français…"
                  class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none resize-y"
                  style="border-color: #e2e8f0; color: #1e293b; line-height: 1.6;">{{ old('description_fr', $partner?->description_fr) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-2" style="color: #475569;">
            Description (EN)
        </label>
        <textarea name="description_en" rows="4"
                  placeholder="Description in English…"
                  class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none resize-y"
                  style="border-color: #e2e8f0; color: #1e293b; line-height: 1.6;">{{ old('description_en', $partner?->description_en) }}</textarea>
    </div>
</div>

{{-- Website --}}
<div>
    <label class="block text-sm font-semibold mb-2" style="color: #475569;">
        Site web
    </label>
    <input type="url" name="website_url"
           value="{{ old('website_url', $partner?->website_url) }}"
           placeholder="https://www.example.org"
           class="w-full text-sm px-4 py-3 rounded-xl border focus:outline-none @error('website_url') border-red-400 @else border-slate-200 @enderror"
           style="color: #1e293b;">
    @error('website_url')
        <p class="text-xs mt-1.5" style="color: #ef4444;">{{ $message }}</p>
    @enderror
</div>

{{-- Status --}}
<div class="flex items-center gap-3 p-4 rounded-xl" style="background-color: #f8f5f0;">
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1"
               {{ old('is_published', $partner?->is_published ?? false) ? 'checked' : '' }}
               class="w-4 h-4 rounded" style="accent-color: #c80078;">
        <div>
            <p class="text-sm font-semibold" style="color: #1e293b;">Publié</p>
            <p class="text-xs" style="color: #64748b;">Visible sur la page partenaires</p>
        </div>
    </label>
</div>
