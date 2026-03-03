@include('header')
<link rel="stylesheet" href="{{ asset('parkingFee.css') }}">
</head>

<script src="{{ asset('common.js') }}"></script>

<script>
    // 停車
    function parking() {
        var location = $('#location').val();
        var carid = $('#carid').val();
        var cartype = $('#cartype').val();
        var captchaText = $('#captchaText').val();

        if (location == "") {
            alert("請選擇欲查詢縣市");
            $('#location').focus();
            return false;
        }

        if (cartype == "") {
            alert("請選擇汽/機車");
            $('#cartype').focus();
            return false;
        }

        if (captchaText == "") {
            alert("請輸入驗證碼");
            refreshImage();
            $('#captchaText').focus();
            return false;
        }

        // 顯示等待動畫
        showLoading();
        
        $.ajax({
            type: "POST",
            url: "/parkingFee",
            data: {
                check: captchaText,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // 驗證成功後再查詢停車資訊（繼續顯示等待動畫）
                    // 若選擇 ALL 則依序查詢所有縣市，並分別顯示縣市標題與該縣市的查詢結果。
                    if (location === 'ALL') {
                        // 列出要查詢的縣市 key 與顯示名稱
                        var locationsList = [
                            {key: 'Keelung', name: '基隆市'},
                            {key: 'Taipei', name: '台北市'},
                            {key: 'NewTaipei', name: '新北市'},
                            {key: 'Taoyuan', name: '桃園市'},
                            {key: 'Hsinchu', name: '新竹市'},
                            {key: 'Hsinchu_s', name: '新竹縣'},
                            {key: 'Taichung', name: '台中市'},
                            {key: 'Changhua', name: '彰化縣'},
                            {key: 'Chiayi', name: '嘉義市'},
                            {key: 'Tainan', name: '台南市'},
                            {key: 'Kaohsiung', name: '高雄市'},
                            {key: 'Pingtung', name: '屏東縣'},
                            {key: 'Taitung', name: '台東縣'}
                        ];

                        $('#carResult').show();
                        $('#carResultContent').empty();

                        var anyFound = false;
                        var idx = 0;
                        var counts = {};

                        function queryNextCity() {
                            if (idx >= locationsList.length) {
                                hideLoading();
                                // 建立摘要顯示：查詢結果 / 車牌號碼 / 各縣市筆數
                                var out = '';
                                out += '<h2>查詢結果</h2>';
                                out += '<p>車牌號碼: ' + (carid || '') + '</p>';
                                out += '<p>查詢縣市:</p>';
                                out += '<div class="city-summary">';
                                locationsList.forEach(function(l) {
                                    var c = counts[l.name] || 0;
                                    out += '<div>' + l.name + ' ' + c + '筆</div>';
                                });
                                out += '</div>';

                                $('#carResultContent').html(out);

                                refreshImage();
                                $('#captchaText').val('');
                                return;
                            }

                            var loc = locationsList[idx++];

                            $.ajax({
                                type: "POST",
                                url: "/parkingFeeCheck",
                                data: {
                                    carid: carid,
                                    location: loc.key,
                                    cartype: cartype,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data) {
                                    // 從後端回傳的 HTML 推算筆數（若後端回傳格式不同，請再調整）
                                    var count = 0;
                                    if (data && data.html && data.html.trim() !== '') {
                                        var html = data.html;
                                        // 優先嘗試統計 <tr> 數量（減去表頭），否則嘗試以特定關鍵字判定
                                        var trMatches = html.match(/<tr\b/gi) || [];
                                        var thMatches = html.match(/<th\b/gi) || [];
                                        count = trMatches.length;
                                        if (thMatches.length > 0 && count > 0) {
                                            // 假設表頭佔一列，減去一列
                                            count = Math.max(0, count - 1);
                                        }

                                        // 若沒有 <tr>，檢查是否有明確的「查無資料」或空字串
                                        if (count === 0) {
                                            var noDataKeywords = /查無資料|無資料|沒有資料|0筆/;
                                            if (noDataKeywords.test(html)) {
                                                count = 0;
                                            } else {
                                                // 嘗試以元素節點數量作為替代（如 list item）
                                                var tmp = document.createElement('div');
                                                tmp.innerHTML = html;
                                                var rowLike = tmp.querySelectorAll('tr, li, .result-item, .row');
                                                count = rowLike.length;
                                            }
                                        }

                                        if (count > 0) anyFound = true;
                                    } else {
                                        count = 0;
                                    }

                                    counts[loc.name] = count;
                                    // 小幅延遲以避免短時間內大量併發請求
                                    setTimeout(queryNextCity, 150);
                                },
                                    error: function(xhr) {
                                        // 發生錯誤視為 0 筆，繼續下一個
                                        counts[loc.name] = 0;
                                        setTimeout(queryNextCity, 150);
                                    }
                            });
                        }

                        // 開始逐一查詢
                        queryNextCity();
                    } else {
                        // 單一縣市查詢（保留原行為）
                        $.ajax({
                            type: "POST",
                            url: "/parkingFeeCheck",
                            data: {
                                carid: carid,
                                location: location,
                                cartype: cartype,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                hideLoading();
                                $('#carResult').show();
                                $('#carResultContent').empty().html(data.html); // 顯示查詢結果
                                refreshImage();
                                $('#captchaText').val('');
                            },
                            error: function(xhr) {
                                hideLoading();
                                alert('查詢失敗，請稍後再試');
                            }
                        });
                    }
                } else {
                    hideLoading();
                    alert(response.message); // 驗證失敗
                    refreshImage();
                    $('#captchaText').val('').focus();
                }
            },
            error: function(xhr) {
                hideLoading();
                alert('伺服器錯誤');
            }
        });
    }

    function refreshImage() {
        // 生成一個隨機的查詢字符串，以便重新加載圖像
        var img = document.getElementById('captcha');
        img.src = '/captchaImage?' + new Date().getTime();
    }

    // Loading dots helper
    var _loadingInterval = null;
    function showLoading() {
        var el = document.getElementById('loadingDots');
        if (!el) return;
        el.style.display = 'block';
        el.textContent = '查詢中';
        if (_loadingInterval) clearInterval(_loadingInterval);
        _loadingInterval = setInterval(function() {
            if (el.textContent.endsWith('...')) {
                el.textContent = '查詢中';
            } else {
                el.textContent += '.';
            }
        }, 500);
    }

    function hideLoading() {
        var el = document.getElementById('loadingDots');
        if (_loadingInterval) {
            clearInterval(_loadingInterval);
            _loadingInterval = null;
        }
        if (el) {
            el.style.display = 'none';
        }
    }

    // 監聽事件
    document.addEventListener('DOMContentLoaded', function() {
        // 第二個 tab
        Tabs.init(1);
        Preview.init();

        // 車牌格式即時驗證
        const caridInput = document.getElementById('carid');
        const msg = document.getElementById('carid-msg');
        const regex = /^.+-.+$/; // 只要中間有一個 "-" 即可

        caridInput.addEventListener('input', function() {
            const value = caridInput.value.toUpperCase(); // 自動轉大寫
            caridInput.value = value;

            if (value === '') {
                msg.textContent = '';
                caridInput.style.borderColor = '';
            } else if (!regex.test(value)) {
                msg.textContent = '車牌格式錯誤，應為 XXX-XXX';
                caridInput.style.borderColor = 'red';
            } else {
                msg.textContent = '';
                caridInput.style.borderColor = 'green';
            }
        });

        // 按 Enter 提交表單
        const form = document.querySelector('form');
        form.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                parking(); // 自定義的提交方法
            }
        });
    });
</script>

<body>
    <section class="previews">
        <div>
            @include('include.left', ['page_chose_1' => $page_chose_1,'articles' => $articles])
        </div> <!--要把資料夾名稱『include』給放進來-->
        <div>
            <div>
                @include('include.nav')
            </div>
            <div>
                <!-- 停車費查詢 -->
                <div class="tab carCont">
                    <div class="col-12 col-sm-12">
                        <p>請輸入車牌號碼，查詢待繳停車費<br>
                            (輸入範例：ABC-5678或123-ABC)
                        </p>

                        <form method="post" id="parkForm">
                            @csrf
                            <table>
                                <tr><td colspan="2"><span id="carid-msg" style="color: red; font-size: 0.5em;"></span></td></tr>
                                <tr>
                                    <td>*車牌號碼:</td>
                                    <td><input type="text" title="車牌號碼" placeholder="請輸入您的車牌號碼" id="carid" name="carid" size="15" required></td>
                                </tr>
                                <tr>
                                    <td>*縣市:</td>
                                    <td><select name="location" id="location" style="width: 18ch;">
                                            <option value="">請選擇查詢縣市</option>
                                            <option value="ALL">所有縣市(耗時較長請耐心等候)</option>
                                            <option value="Keelung">基隆市</option>
                                            <option value="Taipei">台北市</option>
                                            <option value="NewTaipei">新北市</option>
                                            <option value="Taoyuan">桃園市</option>
                                            <option value="Hsinchu">新竹市</option>
                                            <option value="Hsinchu_s">新竹縣</option>
                                            <option value="Taichung">台中市</option>
                                            <option value="Changhua">彰化縣</option>
                                            <option value="Chiayi">嘉義市</option>
                                            <option value="Tainan">台南市</option>
                                            <option value="Kaohsiung">高雄市</option>
                                            <option value="Pingtung">屏東縣</option>
                                            <option value="Taitung">台東縣</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>*車種:</td>
                                    <td>
                                        <select name="cartype" id="cartype" style="width: 18ch;">
                                            <option value="">請選擇車種</option>
                                            <option value="C">汽車</option>
                                            <option value="M">機車</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>*驗證碼:</td>
                                    <td><input id="captchaText" name="captchaText" type="text" title="驗證碼"
                                            placeholder="請輸入驗證碼" size="15" require>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img id="captcha"
                                            class="captcha" src="/captchaImage" alt="captcha">
                                    </td>
                                    <td><input type="button" value="更換圖片" onclick="refreshImage()"></td>
                                </tr>
                            </table>
                            <div class="car">
                                <button id="parkSubmit" type="button" onclick="parking()" title="確定送出">
                                    確定送出</button>
                                <button type="reset" title="清除">
                                    清除</button>
                            </div>
                        </form>
                    </div>
                    <!-- loading dots (顯示於查詢與結果區間) -->
                    <div id="loadingDots" style="display:none; margin:10px 0; font-weight:bold;">查詢中</div>

                    <!-- 送出查詢後的結果，預設隱藏 -->
                    <div class="col-12 col-sm-12" id="carResult">
                        <div id="carResultContent"></div> <!-- 用這個來放查詢結果 -->
                    </div>
                </div>
            </div>
            @include('footer')