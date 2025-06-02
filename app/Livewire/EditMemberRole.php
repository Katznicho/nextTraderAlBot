<?php

namespace App\Livewire;

use App\Models\MemberRole;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class EditMemberRole extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public MemberRole $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_type_id')
                    ->label('Account Type Name')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('role')
                    ->required(),
                Forms\Components\TextInput::make('permissions')
                    ->required(),
            ])
            ->statePath('data')
            ->columns(2)
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
    }

    public function render(): View
    {
        return view('livewire.edit-member-role');
    }
}
