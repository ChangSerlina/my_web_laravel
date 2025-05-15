<hr>
<h2>查詢結果</h2>
@isset($carid, $cityName, $_cartype)
    <p>車牌號碼: {{ $carid }}</p>
    <p>查詢縣市: {{ $cityName }}</p>
    <p>車種: {{ $_cartype }}</p>
    <h3>{!! nl2br(e($_API)) !!}</h3>
@endisset
