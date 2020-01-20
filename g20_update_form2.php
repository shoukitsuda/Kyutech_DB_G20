<HTML>
<HEAD>
  <TITLE>G20データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

G20データ 更新フォーム<BR><BR>

<FORM ACTION="g20_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の従業員番号を取得
$id = (string) $_GET[ id ];

// データベースに接続
// ※ your_db_name のところは自分のデータベース名に書き換える
$conn = pg_connect( "dbname=s2c1117s" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された従業員番号の従業員情報を取得するSQLを作成
$sql = sprintf( "select group_no,population from g20 where id='%s'", $id );

// Queryを実行して検索結果をresultに記録p
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 従業員が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定されたIDのデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の従業員の情報を変数に記録
$curr_group_no = pg_fetch_result( $result, 0, 0 );
$curr_population = pg_fetch_result( $result, 0, 1 );

// 検索結果の開放
pg_free_result( $result );

// 従業員番号を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=id VALUE=%s>\n", $id );


// 部門一覧を取得するSQLの作成
$sql = "select group_no, group_name from gro";

// Queryを実行して検索結果をresultに記録
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

	if ( $group_no == $curr_group_no )
		$checked = "CHECKED";
	else
		$checked = "";

	printf( "<INPUT TYPE=radio NAME=group_no VALUE=%s %s> %s </INPUT>\n", $group_no, $checked, $group_name );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

// // 氏名の入力フィールドを出力
// print( "<BR>\n" );
// print( "IMFの評価：\n" );
// printf( "<INPUT TYPE=text SIZE=24 NAME=imf VALUE=\"%s\">\n", $curr_imf );
// print( "　\n" );

// 年齢の入力フィールドを出力
print( "人口：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=population VALUE=%s>\n", $curr_population );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>
