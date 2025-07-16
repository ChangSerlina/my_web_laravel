<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('class')->options([
                    'home' => 'home',
                    'parkingFee' => 'parkingFee',
                    'contact' => 'contact',
                ])->required(),
                Forms\Components\TextInput::make('route')->required(),
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('image')->required(),
                Forms\Components\TextInput::make('date'),
                Forms\Components\Textarea::make('context')->maxLength(5000)->columnSpan('full')->autosize(), // 自動根據內容調整高度
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('class')->sortable(),
                Tables\Columns\TextColumn::make('route')->searchable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('class')
                    ->options([
                        'home' => 'home',
                        'parkingFee' => 'parkingFee',
                        'contact' => 'contact',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
