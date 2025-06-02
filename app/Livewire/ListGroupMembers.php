<?php

namespace App\Livewire;

use App\Models\GroupMember;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListGroupMembers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(GroupMember::query())
            ->columns([
                Tables\Columns\TextColumn::make('group_account_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('member_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unique_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('anonymous_contribution')
                    ->boolean(),
                Tables\Columns\TextColumn::make('member_role_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('joined_on')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('suspended')
                    ->boolean(),
                Tables\Columns\TextColumn::make('left_on')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('removed_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.list-group-members');
    }
}
