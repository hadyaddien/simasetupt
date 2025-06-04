<?php

namespace App\Filament\Resources\AssetResource\RelationManagers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Detail_asset;
use App\Models\Room;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DetailAssetsRelationManager extends RelationManager
{
    protected static string $relationship = 'detail_assets';

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                TextInput::make('code_asset')
                    ->hidden()
                    ->dehydrated(true),
                Placeholder::make('asset_code_display')
                    ->label('Asset Code')
                    ->content(fn($record) => $record?->code_asset ?? '-')
                    ->columnSpanFull(),

                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $user = User::find($state);
                        if ($user) {
                            $set('division_id', $user->division_id);
                        }
                    })
                    ->required(),

                Select::make('division_id')
                    ->label('Division')
                    ->relationship('division', 'division_name')
                    ->disabled() // tidak bisa diubah
                    ->dehydrated(true) // tetap disimpan saat submit
                    ->required(),

                Select::make('room_id')
                    ->label('Room')
                    ->relationship('room', 'room_name')
                    ->required(),

                Select::make('condition')
                    ->options(Detail_asset::getConditionOptions())
                    ->required(),

                Select::make('asset_status')
                    ->options(Detail_asset::getAssetStatusOptions())
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('condition')
            ->columns([
                TextColumn::make('code_asset'),

                TextColumn::make('room.room_name')
                    ->placeholder('Not Assigned')
                    ->label('Room'),

                TextColumn::make('division.division_name')
                    ->placeholder('Not Assigned')
                    ->label('Division'),

                TextColumn::make('user.name')
                    ->placeholder('Not Assigned')
                    ->label('User'),

                TextColumn::make('condition')
                    ->placeholder('Not Assigned')
                    ->formatStateUsing(fn($state) => Detail_asset::getConditionOptions()[$state] ?? $state),

                TextColumn::make('asset_status')
                    ->placeholder('Not Assigned')
                    ->label('Asset Status')
                    ->formatStateUsing(fn($state) => Detail_asset::getAssetStatusOptions()[$state] ?? $state),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Asset')
                    ->mutateFormDataUsing(function (array $data) {
                        $asset = $this->getOwnerRecord();

                        $categorySlug = $asset->category?->category_slug ?? 'UNK';
                        $category = strtoupper(substr($categorySlug, 0, 4));
                        $name = strtoupper(Str::slug($asset->name, '-'));
                        $prefix = $category . '-' . $name . '-';

                        // Ambil code_asset terakhir dari histori
                        $lastCode = \App\Models\DetailAssetHistory::where('event', 'created')
                            ->whereJsonContains('changes->message', 'Asset created.')
                            ->whereHas('detailAsset', function ($q) use ($asset) {
                                $q->where('asset_id', $asset->id);
                            })
                            ->orderByDesc('created_at')
                            ->pluck('detail_asset_id') // Ambil ID terakhir
                            ->map(function ($id) {
                                return optional(\App\Models\Detail_asset::withTrashed()->find($id))->code_asset;
                            })
                            ->filter()
                            ->first();

                        // Jika tidak ditemukan di atas, fallback ke detail_assets
                        if (!$lastCode) {
                            $lastCode = \App\Models\Detail_asset::withTrashed()
                                ->where('code_asset', 'like', $prefix . '%')
                                ->orderByDesc('code_asset')
                                ->value('code_asset');
                        }

                        $lastNumber = 0;
                        if ($lastCode && preg_match('/(\d+)$/', $lastCode, $matches)) {
                            $lastNumber = (int) $matches[1];
                        }

                        $newCode = $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

                        $data['code_asset'] = $newCode;

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Delete this item?')
                    ->before(function ($record, $action) {
                        $remaining = $record->asset->detail_assets()->count();
                        if ($remaining <= 1) {
                            Notification::make()
                                ->title('Failed to delete')
                                ->body('At least one detail asset must remain.')
                                ->danger()
                                ->persistent()
                                ->send();

                            $action->cancel();
                        }
                    })
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
