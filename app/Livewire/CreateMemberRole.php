<?php

namespace App\Livewire;

use App\Models\MemberRole;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateMemberRole extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
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
                Forms\Components\Select::make('permissions')
                    ->multiple()
                    // ->relationship('permissions', 'name')
                    ->searchable()
                    ->preload()

                    ->required(),
            ])
            ->statePath('data')
            ->columns(2)
            ->model(MemberRole::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = MemberRole::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.create-member-role');
    }
}