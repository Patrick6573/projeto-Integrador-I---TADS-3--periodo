
<section>
    <div>
        <x-input-label for="phone_1" :value="__('Phone 1')" />
        <x-text-input id="phone_1" name="phones[0]" type="text" class="mt-1 block w-full"
            :value="old('phones.0', $user->phones[0]->user_phone ?? '')" required autofocus autocomplete="phone" />
        <x-input-error class="mt-2" :messages="$errors->get('phones.0')" />
    </div>

    <div>
        <x-input-label for="phone_2" :value="__('Phone 2')" />
        <x-text-input id="phone_2" name="phones[1]" type="text" class="mt-1 block w-full"
            :value="old('phones.1', $user->phones[1]->user_phone ?? '')" autofocus autocomplete="phone" />
        <x-input-error class="mt-2" :messages="$errors->get('phones.1')" />
    </div>
</section>