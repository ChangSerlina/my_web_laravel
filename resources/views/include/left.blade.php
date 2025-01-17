<div>
    @switch($page_chose_1)
    @case('include.Roof_Party')
    <figure class="absolute-bg preview__img" style="background-image: url('image/osakajo.jpg');"></figure>
    @case('include.Craft_Beer')
    <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1003');"></figure>
    @case('include.Next_Level_Blog')
    <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=433');"></figure>
    @case('include.VHS_Selfies')
    <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=40');"></figure>
    @case('include.Four_Dollar_Toast')
    <figure class="absolute-bg preview__img" style="background-image: url('https://unsplash.it/2000/1200?image=1074');"></figure>
    @default
    @isset($articles)
    @foreach ($articles as $article)
    <figure class="absolute-bg preview__img" style="background-image: url('{{ $article->image }}');"></figure>
    @endforeach
    @endisset
    @endswitch
    <div class="previews__container">
        <span>Welcome to</span>
        <h1>Serlina Web</h1>
    </div>
</div>