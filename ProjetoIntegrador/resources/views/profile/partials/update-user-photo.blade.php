<section>
    <div>
        <x-input-label for="user_photo" :value="__('Foto do Perfil')" />
        <img src="{{ asset('profile_photos/' . $user->user_photo) }}" alt="Foto do Perfil">
        <input id="user_photo" name="user_photo" type="file" accept="image/*" class="mt-1 block w-full" autofocus autocomplete="photo" />
        <x-input-error class="mt-2" :messages="$errors->get('phones.0')" />
    </div>
</section>


