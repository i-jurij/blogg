<?php

namespace App\Orchid\Screens\Article;

use App\Models\Article;
use App\Orchid\Layouts\Article\ArticleListTable;
use App\Orchid\Layouts\CreateOrUpdateArticle;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ArticleListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'articles' => Article::filters()->defaultSort('created_at', 'desc')
                ->paginate(24),
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return 'Статьи';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать статью')->modal('createArticle')
                ->method('createOrUpdateArticle'),

            // Link::make('Выход')
            //     ->route('platform.logout')
            //     ->icon('logout'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ArticleListTable::class,

            Layout::modal('createArticle', CreateOrUpdateArticle::class)
                ->title('Создание статьи')
                ->size(Modal::SIZE_LG)
                ->applyButton('Создать'),

            Layout::modal('editArticle', CreateOrUpdateArticle::class)
                ->title('Редактирование статьи')
                ->size(Modal::SIZE_LG)
                ->async('asyncGetArticle'),
        ];
    }

    public function asyncGetArticle(Article $article): array
    {
        return ['article' => $article];
    }

    public function createOrUpdateArticle(Request $request): void
    {
        $articleId = $request->input('article.id');
        $article = Article::updateOrCreate([
            'id' => $articleId,
        ], [
            'title' => $request->input('article.title'),
            'excert' => $request->input('article.excert'),
            'content_raw' => $request->input('article.content_raw'),
            'user_id' => auth()->user()->id,
            'rubric_id' => $request->input('article.rubric_id'),
            'keywords' => $request->input('article.keywords'),
            'meta_desc' => $request->input('article.meta_desc'),
            'is_published' => $request->boolean('article.is_published'),
            'published_at' => $request->input('article.published_at'),
        ]);

        $article->tags()->sync($request->input('article.tags'));

        is_null($articleId) ? Toast::info('Статья создана') : Toast::info('Статья обновлена');
    }
}
