<?php

namespace App\Orchid\Layouts;

use App\Models\Rubric;
use App\Models\Tag;
use App\Orchid\Fields\TinyMCE;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateArticle extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('article.id')->type('hidden'),

            Group::make([
                Input::make('article.title')->required()->title('Заголовок'),

                CheckBox::make('article.is_published')
                    ->value(1)
                    ->sendTrueOrFalse()
                    ->title('Опубликована?'),
            ]),

            Group::make([
                Select::make('article.rubric_id')
                    ->title('Рубрика')
                    ->required()
                    ->fromModel(Rubric::class, 'title')
                    ->empty('Не выбрано'),

                Select::make('article.tags.')
                    ->title('Метка (тэг)')
                    ->required()
                    ->multiple()
                    // ->rows(5)
                    ->fromModel(Tag::class, 'title')
                    ->empty('Не выбрано'),
            ]),

            DateTimer::make('article.published_at')
                ->title('Дата публикации')
                ->format('Y-m-d')
                    ->allowInput()
                    ->required(),

            // TextArea::make('article.content_raw')
            //     ->rows(16)->required()->title('Контент'),

            // SimpleMDE::make('article.excert')->title('Краткое описание'),

           // SimpleMDE::make('article.content_raw')->title('Контент'),
// TinyMCE::make('article.content')->title('Содержание'),

            // Code::make('article.content_raw')->title('Контент'),

            // FieldsCode::make('article.content')->language(FieldsCode::MARKUP)->title('Контент'),

         Quill::make('article.content_raw')
                 // ->toolbar(['text', 'color', 'header', 'list', 'format', 'media'])
                 ->title('Контент')->required(),

            Group::make([
                Input::make('article.keywords')->title('Ключевые слова'),
                Input::make('article.meta_desc')->title('Мета деск'),
            ]),
        ];
    }
}
