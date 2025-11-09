<div class="tab">
    <ul itemscope itemtype="">
        @isset($articles)
        @foreach ($articles as $article)
        <li class="preview" itemprop="blogPost" itemscope itemtype="">
            <a class="preview__link" href="{{ route('home_show', ['page_chose' => $article->route]) }}" itemprop="url">
                <span class="preview__date" itemprop="datePublished">{{ $article->date }}</span>
                <h2 class="preview__header" itemprop="name">{{ $article->title }}</h2>
                @if(strlen($article->context)>30)
                <p class="preview__excerpt" itemprop="description">{!! mb_substr(strip_tags($article->context), 0, 35, 'UTF-8') !!} ...</p>
                @else
                <p class="preview__excerpt" itemprop="description">{{ $article->context }}</p>
                @endif
                <span class="preview__more">Read More</span>
            </a>
        </li>
        @endforeach
        @endisset
    </ul>