<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>過去の依頼・対応履歴</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
   <p>【本アプリの使い方】</p>
   <p style="font-size : 12px">マンションの管理人業務を、マンション住人に依頼するために使用するアプリ。<br>
   依頼内容を入力すると、DBに入る＆チャットアプリで住人に依頼できる仕組みになっている。</p>  <br><br>

   <p>依頼フォーマット</p>
    <label>依頼先：<select name = "person" id="person">
        <option value="">--- 依頼先を選択してください ---</option>
        <option value="A">Aさん</option>
        <option value="B">Bさん</option>
     </select>
     </label><br>

     <label>種類：<select name = "category" id=category>
        <option value="">--- 種類を選択してください ---</option>
        <option value="立ち合い">立ち合い</option>
        <option value="内覧">内覧</option>
        <option value="現地確認">現地確認</option>
        <option value="乾球交換">乾球交換</option>
        <option value="その他">その他</option>
     </select>
     </label><br>

     <label>金額：<input type="number" name="fee" id="fee"></label><br>
     <label>詳細コメント：<textArea name="comment" rows="5" cols="40" id="comment"></textArea></label><br>
     <input type="submit" value="送信" id="send">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>




<!-- ここからチャットアプリ -->
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>
<!-- コンテンツ表示画面 -->
<div style="background : #CCFFFF">
    <div>【依頼者・住人間のチャット欄】</div>
    <div>名前: <input type="text" id="username"></div>
    <div>
        <textarea name=comment2 rows="6" id="text2"></textarea>
        <button id="send2">送信</button><br>
    </div>
    <div id="output" style="height:400px;overflow: auto;"></div>
</div>


<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- JQuery -->

<!--** 以下Firebase **-->
<script src="https://www.gstatic.com/firebasejs/5.9.4/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {

// ここにAPIKEY等を入れる必要有
    apiKey:,
    authDomain:,
    databaseURL:,
    projectId:,
    storageBucket:,
    messagingSenderId:
  };
  firebase.initializeApp(config);

  const newPostRef = firebase.database().ref();


$("#send").on("click",function(){
    newPostRef.push({
    username:$("#username").val(),
    person:$("#person").val(),
    category:$("#category").val(),
    fee:$("#fee").val(),
    comment:$('textarea[name="comment"]').val(),
  })
    $("#text").val("");
});

// チャット側での送信機能は時間がなくて断念
// $("#send2").on("click",function(){
//     newPostRef.push({
//     username:$("#username").val(),
//     comment:$('textarea[name="comment2"]').val(),
//   })
//     $("#text2").val("");
// });

newPostRef.on("child_added",function(data){
    const v=data.val();
    let k = data.key;
    const str = '<p>' + "___________________" +'<p>'+ v.username+'<br>'+ v.person+"さん"+'<br>'+"以下の仕事をお願いできますでしょうか？"+'<br>' +"種類：" + v.category+'<br>'+ '</P>'+"金額："+ v.fee+"円"+'</P>'+"詳細："+ v.comment+'</P>';
        var weeks = new Array('日','月','火','水','木','金','土');
        var now = new Date();
        var year = now.getYear(); // 年
        var month = now.getMonth() + 1; // 月
        var day = now.getDate(); // 日
        var week = weeks[ now.getDay() ]; // 曜日
        var hour = now.getHours(); // 時
        var min = now.getMinutes(); // 分
        var sec = now.getSeconds(); // 秒
        if(year < 2000) { year += 1900; }
        // 数値が1桁の場合、頭に0を付けて2桁で表示する指定
        if(month < 10) { month = "0" + month; }
        if(day < 10) { day = "0" + day; }
        if(hour < 10) { hour = "0" + hour; }
        if(min < 10) { min = "0" + min; }
        if(sec < 10) { sec = "0" + sec; }
        // 表示開始
        var h =(month + '月' + day + '日 ' + hour + '時' + min + '分' + sec + '秒</b>');
        // 表示終了
        // -->
        var u =('(了)'); 
        $("#output").append(str,h,u);
        $("#output").scrollTop( $("#output")[0].scrollHeight );
    });




$("#text").on("keydown",function(e){
    if(e.keyCode==13){
        newPostRef.push({
        username:$("#username").val(),
        text:$("#text").val()
    })
    $("#text").val("");
    }
});


</script>
</body>
</html>
