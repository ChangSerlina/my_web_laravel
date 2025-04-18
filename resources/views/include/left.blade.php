<div>
    @isset($articles)
    @foreach ($articles as $article)
    @switch($page_chose_1)
    @case('include.osaka')
    <figure class="absolute-bg preview__img" style="background-image: url('{{ $article->image }}');"></figure>
    @case('include.tainan')
    <figure class="absolute-bg preview__img" style="background-image: url('{{ $article->image }}');"></figure>
    @case('include.malaysia')
    <figure class="absolute-bg preview__img" style="background-image: url('{{ $article->image }}');"></figure>
    @default
    <figure class="absolute-bg preview__img" style="background-image: url('{{ $article->image }}');"></figure>
    @endswitch
    @endforeach
    @endisset

    <div class="previews__container">
        <span>Welcome to</span>
        <h1>Serlina Web</h1>
    </div>
</div>