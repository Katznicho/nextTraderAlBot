<div>
    <form wire:submit="create">
        {{ $this->form }}

        <button type="submit" class="my-4 py-2 text-center justify-center px-2 bg-success rounded-lg" style="background-color: rgb(0, 89, 255); color: white;">
           Create Account
        </button>
    </form>

    <x-filament-actions::modals />
</div>
