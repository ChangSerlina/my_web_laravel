            <header>
                <ul class="tabs">
                    <li class="tabs__item item"><a href="{{ route('home_show') }}">首頁</a></li>
                    <li class="tabs__item item"><a href="{{ route('parkingFee_show') }}">停車費查詢</a></li>
                    <li class="tabs__item item"><a href="{{ route('report_show') }}">聯絡我們</a></li>
                    @guest
                    <li class="tabs__item item"><a href="{{ route('login') }}">登入</a></li>
                    @else
                    <li class="tabs__item item"><a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{Auth::user()->name}} 登出</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endguest
                </ul>
            </header>