<?php

namespace App\Filament\Approver\Resources;

use App\Filament\Approver\Resources\DamageReportResource\Pages;
use App\Filament\Approver\Resources\DamageReportResource\RelationManagers;
use App\Models\DamageReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class DamageReportResource extends Resource
{
    protected static ?string $model = DamageReport::class;

    protected static ?string $navigationLabel = 'View Damage Reports';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                DamageReport::query()
                    ->where('validator_status', 'approved')->orderBy('created_at', 'desc') // hanya yang sudah ditindaklanjuti
            )
            ->columns([
                ImageColumn::make('attachment')
                ->label('Evidence')
                ->height(60)
                ->width(60)
                ->square()
                ->extraImgAttributes(['style' => 'object-fit: cover;'])
                ->url(fn($record) => Storage::url($record->attachment))
                ->openUrlInNewTab(), // bisa diklik untuk lihat lebih besar
                TextColumn::make('detailAsset.code_asset')->label('Code Asset'),
                TextColumn::make('user.name')->label('Reporter'),
                TextColumn::make('status')->label('Damage Status'),
                TextColumn::make('created_at')->label('Reported At')->dateTime(),
            ])
            ->actions([]) // tidak bisa edit/delete
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDamageReports::route('/'),
        ];
    }
}
