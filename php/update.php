<?php

$conn = mysqli_connect("localhost", "root", "", "kabyle_word");
// Check connection
if(!$conn){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function is_exist($mot)
{
	$conn = mysqli_connect("localhost", "root", "", "kabyle_word");
	$sql = "SELECT * FROM words WHERE word='$mot' LIMIT 1";
	$result = mysqli_query($conn,$sql);
	return mysqli_num_rows($result);
}

$str = file_get_contents("TEXT_Extract.txt");

$str = preg_replace('/[0-9\':;,.-?!«�"(\/)+*#»„<>]/i', " ", $str);
$word_list = explode(" ",$str);

$word_added = 0;
$word_skiping = 0;

for ($i=0; $i < count($word_list); $i++) {
	$mot = preg_replace('/[\s+0-9\':;,.-?!«�"(\/)+*#»̣“<>]/i',"",strtolower($word_list[$i]));
	if(!empty($mot) AND !preg_match("[o]", $mot)){
		if(!is_exist($mot))
		{
			$sql = "INSERT INTO words(word) VALUES('$mot')";
			mysqli_query($conn,$sql);
			echo "\033[33m[+] ".$mot ."\n";
			$word_added++;
		}else{
			//echo "\033[31m[x] ".$mot."\n";
			$word_skiping++;
		}
	}
}
echo "\n\nIl Ya ".count($word_list)." mot : \n\033[33m[+] " . $word_added . " ".$word_added*100/count($word_list)." % \n\033[31m[x] ". $word_skiping." ".$word_skiping*100/count($word_list)." %\n"; 
?>
