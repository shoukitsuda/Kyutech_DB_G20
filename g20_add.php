<HTML>
<HEAD>
  <TITLE>G-20データ追加処理スクリプト</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<!-- ここからPHPのスクリプト始まり -->
<?php

// フォームから渡された引数を取得
$id = $_GET[ id ];
$country = $_GET[ country ];
$continent = $_GET[ continent ];
$imf = $_GET[ imf ];
$population = $_GET[ population ];
$group_no = $_GET[ group_no ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=s2c1117s" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// データ挿入のSQLを作成
$sql = sprintf( "insert into g20( id, country, continent, imf, population, group_no) values( '%s','%s', '%s', '%s', '%s','%s' );",$id, $country, $continent, $imf, $population, $group_no );

// 確認用のメッセージ表示
print( "クエリー「" );
print( $sql );
print( "」を実行します。<BR>" );

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

データの追加処理が完了しました。<BR>
<BR>
<A HREF="menu.html">操作メニューに戻る</A>

</BODY>
</HTML>
