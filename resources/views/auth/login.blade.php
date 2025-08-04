@include('header')
</head>
<style>
    .submit {
        border: none;
        color: var(--color-alpha);
        padding: 8px;
    }

    .previews__container {
        margin: 0;
        margin-bottom: 1rem;
    }
</style>

<body>
    <div class="previews__container">
        <span>Welcome to</span>
        <h1>Serlina Web</h1>
    </div>
    <div class="center">
        <h2 class="preview__header">會員登入</h2>

        @if ($errors->any())
        <div style="color:red;">
            {{ $errors->first('email') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label>電子郵件：</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required><br><br>

            <label>密碼：</label><br>
            <input type="password" name="password" required><br><br>

            <button class="submit" type="submit">登入</button>
        </form>
    </div>
</body>

</html>