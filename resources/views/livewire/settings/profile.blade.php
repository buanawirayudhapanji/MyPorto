<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your public profile details and identity.')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- Avatar Upload & Preview -->
            <div class="flex items-center gap-6">
                <div class="relative">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="size-20 rounded-full object-cover border border-zinc-200 dark:border-zinc-700" alt="Avatar Preview" />
                    @elseif ($avatar_path)
                        <img src="{{ asset('storage/' . $avatar_path) }}" class="size-20 rounded-full object-cover border border-zinc-200 dark:border-zinc-700" alt="Current Avatar" />
                    @else
                        <flux:avatar size="xl" class="size-20" :name="$name" />
                    @endif
                </div>
                <flux:field class="flex-1">
                    <flux:label>{{ __('Foto Profil') }}</flux:label>
                    <input type="file" wire:model="avatar" accept="image/*" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300 cursor-pointer" />
                    <flux:error name="avatar" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <flux:input wire:model="username" :label="__('Username (untuk URL publik)')" type="text" required placeholder="panji-wira" />

                <!-- Name -->
                <flux:input wire:model="name" :label="__('Nama Lengkap')" type="text" required autocomplete="name" />

                <!-- Email -->
                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />
                    @if ($this->hasUnverifiedEmail)
                        <flux:text class="mt-2 text-xs">
                            {{ __('Your email address is unverified.') }}
                            <flux:link class="cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Resend link') }}
                            </flux:link>
                        </flux:text>
                    @endif
                </div>

                <!-- Status -->
                <flux:select wire:model="status" :label="__('Status Pendidikan/Kelulusan')">
                    <option value="">-- Pilih Status --</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Fresh Graduate">Fresh Graduate</option>
                    <option value="Lulusan SMA/SMK">Lulusan SMA/SMK</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="Lainnya">Lainnya</option>
                </flux:select>

                <!-- Pekerjaan -->
                <flux:input wire:model="job_title" :label="__('Pekerjaan/Profesi')" type="text" placeholder="Fullstack Web Developer" />

                <!-- Phone -->
                <flux:input wire:model="phone" :label="__('Nomor Telepon')" type="text" placeholder="e.g. 08123456789" />

                <!-- Tanggal Lahir -->
                <flux:input wire:model="birth_date" :label="__('Tanggal Lahir')" type="date" />

                <!-- Link GitHub -->
                <flux:input wire:model="github_url" :label="__('Link GitHub')" type="url" placeholder="https://github.com/username" />

                <!-- Link LinkedIn -->
                <flux:input wire:model="linkedin_url" :label="__('Link LinkedIn')" type="url" placeholder="https://linkedin.com/in/username" />
            </div>

            <!-- Alamat -->
            <flux:textarea wire:model="address" :label="__('Alamat')" rows="3" placeholder="Masukkan alamat lengkap Anda..." />

            <!-- Keahlian Utama (Tags) -->
            <flux:field>
                <flux:label>{{ __('Keahlian Utama (Ketik lalu tekan Enter)') }}</flux:label>
                <flux:input wire:model="new_skill" wire:keydown.enter.prevent="addSkill" placeholder="Contoh: PHP, Laravel, Tailwind CSS (lalu enter)" />
                <flux:error name="skills" />

                <div class="flex flex-wrap gap-2 mt-3">
                    @forelse ($skills as $index => $skill)
                        <flux:badge size="sm" class="flex items-center gap-1.5 bg-[#D6A34E]/10 text-[#8A6A2A] dark:text-[#D6A34E] border-none px-2.5 py-1 font-mono text-xs rounded-md">
                            <span>{{ $skill }}</span>
                            <button type="button" wire:click="removeSkill({{ $index }})" class="text-[#8A6A2A] dark:text-[#D6A34E] hover:text-red-500 font-bold focus:outline-none text-xs ml-0.5">
                                &times;
                            </button>
                        </flux:badge>
                    @empty
                        <flux:text class="text-xs text-zinc-400 italic">{{ __('Belum ada keahlian yang ditambahkan.') }}</flux:text>
                    @endforelse
                </div>
            </flux:field>

            <!-- CV Uploader -->
            <flux:field>
                <flux:label>{{ __('Dokumen CV') }}</flux:label>
                @if ($cv_path)
                    <div class="flex items-center gap-2 mb-2 text-xs">
                        <flux:icon name="document" class="size-4 text-zinc-500" />
                        <a href="{{ asset('storage/' . $cv_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline hover:text-blue-800">{{ __('Lihat CV Saat Ini') }}</a>
                    </div>
                @endif
                <input type="file" wire:model="cv" accept=".pdf,.doc,.docx" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-800 dark:file:text-zinc-300 cursor-pointer" />
                <flux:error name="cv" />
            </flux:field>

            <!-- Deskripsi Tambahan / Bio -->
            <flux:textarea wire:model="bio" :label="__('Deskripsi Tambahan')" rows="5" placeholder="Tuliskan tentang diri Anda secara singkat dan profesional..." />

            <!-- Sembunyikan Kontak -->
            <flux:checkbox wire:model="hide_contact" :label="__('Sembunyikan kontak sensitif (Telepon, Email, Alamat) dari publik')" />

            <!-- Save Button -->
            <div class="flex items-center gap-4 pt-4 border-t border-zinc-200/60 dark:border-[#1F212B]">
                <flux:button type="submit" class="!bg-[#D6A34E] !text-[#0A0B0F] hover:!bg-[#E6B868] !border-none font-semibold shadow-[0_0_0_1px_rgba(214,163,78,0.15)]">{{ __('Save Changes') }}</flux:button>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <div class="mt-12 pt-8 border-t border-zinc-100 dark:border-zinc-800">
                <livewire:settings.delete-user-form />
            </div>
        @endif
    </x-settings.layout>
</section>
