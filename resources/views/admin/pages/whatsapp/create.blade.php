<x-admin.app-layout pageTitle="Add Contact">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add WhatsApp Contact
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'WhatsApp' => route('admin.whatsapp.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.whatsapp.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- LEFT COLUMN: MAIN INFO --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <h3 class="font-bold text-gray-700">Contact Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="title" value="Title" />
                                    <x-admin.text-input name="title" :value="old('title')" class="w-full mt-1" required placeholder="e.g. Sales Support" />
                                    <x-admin.input-error :messages="$errors->get('title')" class="mt-1" />
                                </div>

                                <div>
                                    <x-admin.input-label for="subtitle" value="Subtitle (Optional)" />
                                    <x-admin.text-input name="subtitle" :value="old('subtitle')" class="w-full mt-1" placeholder="e.g. Order Inquiry" />
                                    <x-admin.input-error :messages="$errors->get('subtitle')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-admin.input-label for="phone" value="Phone Number (WhatsApp)" />
                                <x-admin.text-input name="phone" :value="old('phone')" class="w-full mt-1 font-mono" required placeholder="6281234567890" />
                                <p class="text-xs text-gray-500 mt-1">Gunakan format internasional tanpa '+' (contoh: 628...)</p>
                                <x-admin.input-error :messages="$errors->get('phone')" class="mt-1" />
                            </div>

                            <div class="mt-4">
                                <x-admin.input-label for="message" value="Default Message (Optional)" />
                                <textarea name="message" rows="2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1" placeholder="Halo, saya butuh bantuan...">{{ old('message') }}</textarea>
                                <x-admin.input-error :messages="$errors->get('message')" class="mt-1" />
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                <h3 class="font-bold text-gray-700">Appearance</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="icon" value="Icon (Lucide)" />
                                    <select name="icon" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="shopping-bag" {{ old('icon') == 'shopping-bag' ? 'selected' : '' }}>Shopping Bag</option>
                                        <option value="wrench" {{ old('icon') == 'wrench' ? 'selected' : '' }}>Wrench (Technical)</option>
                                        <option value="shield-check" {{ old('icon') == 'shield-check' ? 'selected' : '' }}>Shield (Warranty)</option>
                                        <option value="message-circle" {{ old('icon') == 'message-circle' ? 'selected' : '' }}>Message</option>
                                        <option value="user" {{ old('icon') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="phone" {{ old('icon') == 'phone' ? 'selected' : '' }}>Phone</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('icon')" class="mt-1" />
                                </div>

                                <div>
                                    <x-admin.input-label for="color" value="Color Theme" />
                                    <select name="color" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Green (Sales)</option>
                                        <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Blue (Tech)</option>
                                        <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }}>Orange (Warranty)</option>
                                        <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Red</option>
                                        <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Purple</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('color')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SETTINGS --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Settings</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', 0)" class="w-full mt-1" min="0" />
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                                    <x-admin.input-error :messages="$errors->get('order')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Save Contact
                                </x-admin.primary-button>
                                <a href="{{ route('admin.whatsapp.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>