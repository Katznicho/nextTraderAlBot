<?php

namespace App\Livewire;

use App\Models\AccountType;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\Select;

class CreateAccountType extends Component implements HasForms
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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),

                Forms\Components\Select::make('status')
                ->native(false)
                    ->label('Status')
                    ->searchable()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
            ])
            ->statePath('data')
            ->columns(2)
            ->model(AccountType::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = AccountType::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.create-account-type');
    }
}
