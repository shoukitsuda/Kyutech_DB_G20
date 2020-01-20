<HTML>
<HEAD>
  <TITLE>G-20の検索フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

G-20データ 検索フォーム<BR><BR>

検索したいG-20加盟国のグループ番号を選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="g20_search.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=s2c1117s" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// SQLを作成
$sql = "select group_no, group_name from gro";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検索結果を選択肢として表示
for ( $i=0; $i<$rows; $i++ )
{
	// 部門の選択のためのラジオボタンを表示
	$group_no = pg_fetch_result( $result, $i, 0 );
	$group_name = pg_fetch_result( $result, $i, 1 );
	print( "<INPUT TYPE=\"radio\" NAME=\"group_no\" VALUE=\"$group_no\"> $group_name </INPUT></BR>\n" );
}

// 全ての部門の選択肢のラジオボタンを表示
print( "<INPUT TYPE=\"radio\" NAME=\"group_no\" VALUE=\"ALL\" CHECKED>全てのグループ</INPUT></BR>\n" );

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

<BR>
<A HREF="menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>
