<HTML>
<HEAD>
  <TITLE>G20データ追加フォーム（動的生成版）</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

G20データ 追加フォーム<BR><BR>

<FORM ACTION="g20_add.php" METHOD="GET">

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


// 最も大きなIDを取り出すSQLの作成
$sql = "select max(id) from g20";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 最大の従業員番号を取得
if ( pg_num_rows( $result ) > 0 )
	$max_population = pg_fetch_result( $result, 0, 0 );
$max_population ++;

// 従業員番号の初期値を指定して入力エリアを作成
print( "ID：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=id VALUE=%04s>", $max_id ); // 必ず４桁で出力、空白があれば0で埋める
print( "<BR>\n" );

// 検索結果の開放
pg_free_result( $result );

// 部門一覧を取得するSQLの作成
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

// 部門の数だけ選択肢を出力
print( "グループ：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$group_no = pg_fetch_result( $result, $i, 0 );
	$group_name = pg_fetch_result( $result, $i, 1 );
	printf( "<INPUT TYPE=\"radio\" NAME=\"group_no\" VALUE=\"%s\"> %s </INPUT>\n", $group_no, $group_name );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

国・地域名：
<INPUT TYPE="text" SIZE="12" NAME="country">

大陸：
<INPUT TYPE="text" SIZE="5" NAME="continent">
　
IMFの評価：
<INPUT TYPE="text" SIZE="5" NAME="imf">

人口：
<INPUT TYPE="text" SIZE="5" NAME="population">

グループ番号：
<INPUT TYPE="int" SIZE="2" NAME="group_no">


<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
