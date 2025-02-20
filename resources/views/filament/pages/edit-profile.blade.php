<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <button type="submit" class="my-4 filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 text-white focus:ring-white border-transparent">
            Save Changes
        </button>
    </form>
</x-filament::page>