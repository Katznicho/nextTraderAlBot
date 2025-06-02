<?php

namespace App\Livewire;

// use App\Models\Account;
use App\Models\AccountType;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateAccount extends Component implements HasForms
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
                Forms\Components\TextInput::make('member_id')
                    ->label('Member Identifier')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('account_type_id')
                ->label('Account Type')
                    ->options(function (): array {
                        return AccountType::all()->pluck('name', 'id')->all();
                    })
                    ->searchable()
                    ->required(),
                    
                Forms\Components\TextInput::make('duration')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                ->label('Creation Date')
                ->displayFormat(function (): string {
                    // if (auth()->user()->country_id === 'gb') {
                    //     return 'd/m/Y';
                    // }
             
                    return 'd/m/Y';
                })
                    ->required(),
            ])
            ->columns(2)
            ->statePath('data')
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
        return view('livewire.create-account');
    }
}
