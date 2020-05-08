
<html>
<head><title>Dynamic Web Programming - Practice 08</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../../../css/common.css" type="text/css">



<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {	color: #0000FF;
	font-size: larger;
}
.style3 {color: #0000FF}
-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000">

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="76%"><h2>Dynamic Web Programming (動態網頁程式設計) - Spring 2019 (108-1) <a name="Top"></a></h2></td>
    <td width="24%" nowrap>
<div align="right"><font size="-1">Last updated on <!-- #BeginDate format:Am3 -->11/26/2019<!-- #EndDate --></font>
  
  <br>
        <a href="../2010Fall_DDWP.htm">home</a> 
        . <a href="#" onClick="javascript:history.back()">back</a>
</div></td>
  </tr>
</table>
<h2>Practice 09 - sqli</h2>
<ol>
  <li>請設計PHP網頁（命名為 Practice09.php）</li>
  <li>請將網頁上傳至 http://www1.pu.edu.tw/~yourID/1081DDWP/ 目錄。</li>
</ol>

<p><strong>Part 1: 建立資料庫及資料表</strong></p>
<ol>
  <li>於phpMyAdmin建立<span class="style1">library</span>資料庫，</li>
  <li>下載 <a href="library.sql"><strong>library.sql</strong></a>，並於phpMyAdmin下執行。</li>
</ol>



<hr>

<p><strong>Part 2: 查詢資料</strong> <strong>(利用mysql database extensions)</strong></p>
<ol>
  <li>設定meta <span class="red">&lt;meta charset=&quot;utf-8&quot;&gt;</span></li>
  <li>建立MySQL的資料庫連結 <br>
      <span class="style1">$link = @mysqli_connect( 'localhost', 
                  'root',       
    '', 'library');</span> // 如果PHP 放置於個人的PC<br>
或<br> 
    <span class="style1">$link = @mysqli_connect( '140.128.10.40', 
      'dwpuser',       
      'resupwd7', 'library');</span> // 如果PHP 放置於 www1</li>
  <li><span class="red">mysqli_select_db($link, 'library'); </span> //選擇資料庫<br>
  </li>
  <li>指定SQL查詢字串<br>
    $sql = &quot;SELECT * FROM book &quot;;<br>
  echo &quot;SQL查詢字串: $sql &lt;br&gt;&quot;;</li>
  <li>送出utf8編碼的MySQL指令<span class="style2"><br>
      </span><span class="style3"><span class="style1">mysqli_query($link, 'SET CHARACTER SET utf8' );</span><br>
      <span class="style1">mysqli_query(
$link, &quot;SET collation_connection = 'utf8_general_ci'&quot;);</span></span></li>
  <li>送出查詢的SQL指令<br>
    if ( <span class="style1">$result = mysqli_query($link, $sql)</span> ) { <br>
    echo &quot;&lt;b&gt;圖書資料:&lt;/b&gt;&lt;br&gt;&quot;;  // 顯示查詢結果<br>
while( <span class="style1">$row = mysqli_fetch_assoc($result)</span> ){ <br>
echo $row[&quot;id&quot;].&quot;-&quot;.$row[&quot;book_name&quot;].&quot; (&quot;.$row[&quot;author&quot;].&quot;)&lt;br&gt;&quot;;<br>
}} </li>
  <li>釋放佔用的記憶體 <br>
      <span class="style1">mysqli_free_result($result);</span> </li>
  <li>關閉資料庫連結<br>
    <span class="style1">mysqli_close($link);</span><br>
  </li>
</ol>
<div align="center">
  <p><strong>範例</strong></p>
</div>


<p>
<?php

//建立MySQL的資料庫連結 
//$link = mysqli_connect( '140.128.10.40:13306', 'root', 'yn2^UTIV', 'library'); // 如果PHP 放置於個人的PC
//或
$link = mysqli_connect( '140.128.10.40:13306', 'dwpuser', 'resupwd7', 'library');// or die("error db connecting"); // 如果PHP 放置於 www1
echo "***************";


//mysqli_select_db('library', $link); //選擇資料庫


//指定SQL查詢字串
$sql = "SELECT * FROM book ";
echo "SQL查詢字串: $sql <br>";

//送出utf8編碼的MySQL指令
mysqli_query($link, "SET CHARACTER SET utf8");
mysqli_query($link, "SET collation_connection = 'utf8_general_ci'");
//送出查詢的SQL指令
if ( $result = mysqli_query($link,$sql) ) { 
	echo "<b>圖書資料:</b><br>"; // 顯示查詢結果
	while( $row = mysqli_fetch_assoc($result) ){
		echo $row["id"]."-".$row["book_name"]." (".$row["author"].")<br>";
	} 
}
//釋放佔用的記憶體 
mysqli_free_result($result); 

//關閉資料庫連結
mysqli_close($link);

?>
</p>

<hr>
<p><strong>Part 3: 查詢資料以表格方式呈現</strong></p>
<div align="center">
  <p><strong>範例</strong></p>
</div>


  <?php

//建立MySQL的資料庫連結 
//$link = mysqli_connect( 'localhost', 'root', '', 'library'); // 如果PHP 放置於個人的PC

//或
$link = mysqli_connect( '140.128.10.40:13306', 'dwpuser', 'resupwd7', 'library'); //or die("error db connecting"); // 如果PHP 放置於 www1


//mysql_select_db('library', $link); //選擇資料庫


//指定SQL查詢字串
$sql = "SELECT * FROM book ";
echo "SQL查詢字串: $sql <br>";

//送出utf8編碼的MySQL指令
mysqli_query($link, "SET CHARACTER SET utf8");
mysqli_query($link, "SET collation_connection = 'utf8_general_ci'");

//送出查詢的SQL指令
if ( $result = mysqli_query($link,$sql) ) { 

	echo "<b>圖書資料:</b><br>"; // 顯示查詢結果
	
	
	echo "<table border='1' align='center'><tr align='center'>";
      for ($i = 0; $i < mysqli_num_fields($result); $i++)
        echo "<td>" . mysqli_fetch_field($result)->name. "</td>";		
      echo "</tr>";
	
      while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
			{
        echo "<tr>";			
        for($i = 0; $i < mysqli_num_fields($result); $i++)
          echo "<td>$row[$i]</td>";					

        echo "</tr>";				
      }
      echo "</table>" ;


}
//釋放佔用的記憶體 
mysqli_free_result($result); 

//關閉資料庫連結
mysqli_close($link);

?>



<p>&nbsp;</p>


</body>
</html>
