<?php
function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
}
function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}
$afrad=file_get_contents("people.json");
$payam=file_get_contents("messages.txt");
$afrad_decode=json_decode($afrad,true);
$en_name_random = array_rand($afrad_decode);
$myfile = fopen("messages.txt", "r");
$lines = file("messages.txt");
if(isset($_POST['question']) && $_POST['question']!='')
{
    
    $question= $_POST['question'] ;
    $en_name = $_POST['person'];
    $fa_name = $afrad_decode[$_POST['person']];
    $hash= intval(hash("sha256",$en_name.$question))%16;
    if(startsWith($question,'آیا') && (endsWith($question,'?')) || (endsWith($question,'؟'))){
    $msg = $lines[$hash];
    }
    else{
    $msg = 'سوال درستی پرسیده نشده';
    }

    

}
else{
    $question= null ;
    $en_name = $en_name_random;
    $fa_name = $afrad_decode[$en_name_random];
    $msg = 'سوال خود را بپرس!';
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <?php 
        if(isset($question)){?>
        <span id="label">
        پرسش:
        </span>
        <?php } ?>
        <span id="question"><?php echo $question ?></span>
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
                foreach ($afrad_decode as $key => $value) 
                {
                    if($key==$en_name)
                    echo "<option value=$key selected>$value</option>";
                
                    else
                    {
                    echo "<option value=$key>$value</option>";

                    }
                }
                 
                ?>

            </select>
            <input type="submit" value="بپرس"/>
            
        </form>
    </div>
</div>
</body>
</html>