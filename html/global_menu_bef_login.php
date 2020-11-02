<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ログイン</title>
    </head>
    <body>
        <ul class="menubar">
            <li class="menubar-item">
                <span class="menubar-icon">ようこそ</span>
            </li>
            <li class="menubar-item">
                <form id="loginForm" name="loginForm" action="/login.php" method="get">
                    <input type="submit" id="login" name="login" value="ログイン" class="menubar-btn link">
                </form>
            </li>
            <li class="menubar-item">
                <form action="/user/new.php" method="get">
                    <input type="submit" value="新規登録" class="menubar-btn link">
                </form>
            </li>
            <li class="menubar-item">
                <form id="toTop" name="toTop" action="<?php echo '/post/index.php' ?>" method="post">
                <input type="submit" id="top" name="top" value="トップに戻る" class="menubar-btn link">
                </form>
            </li>
        </ul>

        <hr>

    </body>
</html>
