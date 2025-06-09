@include('header')
</head>
<style>
    .previews__container {
        margin: 0;
    }
</style>

<body>
    <div class="previews__container">
        <span>Welcome to</span>
        <h1>Serlina Web</h1>
    </div>
    <div class="center">
        <h2 class="preview__header">請驗證您的信箱</h2>

        <p>我們已寄送一封驗證信到您的信箱。請點擊信中的連結以完成驗證。</p>

        @if (session('message'))
        <div style="color: green">{{ session('message') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">重新寄送驗證信</button>
        </form>
    </div>
</body>

</html>