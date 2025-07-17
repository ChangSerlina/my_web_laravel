            <div>
                @isset($articles)
                @foreach ($articles as $article)

                @php
                    // 判斷是否有圖片，並產生圖片完整網址
                    $hasImage = !empty($article->image) && is_file(storage_path('app/public/' . $article->image));

                    $imagePath = $hasImage
                        ? asset('storage/' . $article->image)
                        : asset('images/osakajo.jpg');
                @endphp

                @switch($page_chose_1)
                @case('include.osaka')
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @case('include.tainan')
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @case('include.malaysia')
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @case('parkingFee')
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @default
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @endswitch
                @endforeach
                @endisset

                <div class="previews__container">
                    <span>Welcome to</span>
                    <h1>Serlina Web</h1>
                </div>
            </div>
