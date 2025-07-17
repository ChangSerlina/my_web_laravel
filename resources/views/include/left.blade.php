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
                <figure class="absolute-bg preview__img" style="background-image: url('{{ $imagePath }}');"></figure>
                @endforeach
                @endisset

                <div class="previews__container">
                    <span>Welcome to</span>
                    <h1>Serlina Web</h1>
                </div>
            </div>
