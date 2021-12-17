<?php
$people = file_get_contents("people.json");
$bozorgan = json_decode($people, true);
$question = $_POST["question"];
if ($_POST["person"] == NULL) {
    $en_name = array_rand($bozorgan);
    $fa_name = $bozorgan[$en_name];
}
else{
    $en_name = $_POST["person"];
    $fa_name = $bozorgan[$en_name];
}
if (empty($question)){
    $msg = "سوال خود را بپرس!";
} 
$jomle = explode("\n", file_get_contents("messages.txt"));
if((!preg_match("/\؟/i", $question) && !preg_match("/\?/i", $question))||!preg_match("/آیا/i", $question) ){
    $msg="سوال درستی پرسیده نشده";
}
else {$msg = $jomle[hexdec(substr(md5($question.$en_name),0,15))%16];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
    <?php if($question != NULL) { ?>
        <span 
            id="label">پرسش:
        </span>
        <span 
            id="question"><?php echo $question ?>
        </span>
    <?php } ?>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach($bozorgan as $key => $value) {
                    if($key==$en_name){
                        ?><option value="<?php echo $key; ?>" selected><?php echo $value ?></option><?php
                    } 
                    else{?><option value="<?php echo $key; ?>"><?php echo $value ?></option><?php }
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>