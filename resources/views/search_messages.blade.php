</html>
<header>
</header>

<body>
    <a href="/">topに戻る</a>
    <h2>このページで上手くSQLインジェクションしてユーザーのパスワードを取得してみましょう。</h2>
    <form action="/search_messages" method="get">
        <div>
            検索したいメッセージのキーワード
            <input type="text" name="message">
        </div>
        <div>
            閲覧したい値を選択してください
            <div><input type="checkbox" name='param1' value="u.id">ユーザーID</div>
            <div><input type="checkbox" name='param2' value="u.name">ユーザー名</div>
            <div><input type="checkbox" name='param3' value="m.body">メッセージ</div>
        </div>
        <input type="submit" value="検索">
    </form>
    <h3 style="margin-top:30px;">検索結果</h3>
    @foreach ($all as $one)
        <div style="margin-bottom:10px;border-bottom:1px solid;">{{ implode(',', $one) }}</div>
    @endforeach
</body>

</html>
