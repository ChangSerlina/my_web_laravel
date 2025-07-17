<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\article;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// 表單內的元件
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('圖片設定')
                    ->schema([
                        //
                        FileUpload::make('image')
                            ->image()
                            ->imageEditor()  // editable
                            ->imagePreviewHeight('250') // 啟用預覽
                            ->imageEditorAspectRatios([  // for cropping image
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->visibility('public') // Set visibility to private??
                            ->label('圖片') // Label for the file upload field 
                            ->disk('public') // Specify the disk where files will be stored
                            ->directory('image') // Specify the directory within the disk
                            ->preserveFilenames() // Preserve original filenames
                            ->maxSize(30760) // Set maximum file size in KB (3 MB in this case)
                            ->downloadable()
                    ])->columns(1),
                Section::make('基本資料')
                    ->schema([
                        //
                        Forms\Components\Select::make('class')->options([
                            'home' => 'home',
                            'parkingFee' => 'parkingFee',
                            'contact' => 'contact',
                        ])->required()->label('頁籤'),
                        Forms\Components\TextInput::make('route')->required()->label('網址路徑'),
                        Forms\Components\TextInput::make('title')->required()->label('標題'),
                        Forms\Components\TextInput::make('date')->label('顯示日期'),
                        Forms\Components\Textarea::make('context')->label('內文')->maxLength(5000)->columnSpan('full')->autosize(), // 自動根據內容調整高度
                    ])->columns(2),
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
