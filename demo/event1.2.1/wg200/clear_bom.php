<?php
/**
 * Created by PhpStorm.
 * -------------------------
 *Author:NOCNing
 * -------------------------
 *Date:2016/8/17 18:00
 * -------------------------
 *Caution:No comments for u            ( ˇˍˇ )
 *        it was hard to write
 *        so it should be hard to read O(∩_∩)O~
 **/
//shadowchao.com
$s=0;//统计成功数
$f=0;//统计失败数
//遍历所有文件
function find_allfile(){
    $i="*";
    while($file=glob($i)){
        foreach($file as $s){
            if(!is_dir($s))$allfile[]=$s;
        }
        $i.="/*";
    }
    return $allfile;
}
//清除BOM标记
function del_bom(){
    global $s,$f;
    $file=find_allfile();
    foreach($file as $fname){
        $fname=dirname(__FILE__)."//".$fname;
        $filecont=@file_get_contents($fname);
        $bom=substr($filecont,0,3);
        $bom=bin2hex($bom);
        if($bom=="efbbbf"){ //判断文件中的前3个字节是否为BOM标记值
            $filecont=substr($filecont,3);
            $result=@file_put_contents($fname,$filecont,LOCK_EX);
            if($result){
                echo '[file] '.$fname.' --- --- <em style=/"color:green/">清除成功</em><br />';$s++;
      }else{
                echo '[file] '.$fname.' --- --- <em style=/"color:red/">清除失败</em>（文件只读或者被占用）<br />';$f++;
      }
        }
    }
}
del_bom();
if($s==0 && $f==0){
    echo "<p>所有文件正常，没有发现BOM标记。</p>";
}else{
    echo "<p>统计结果：清除成功($s) | 清除失败($f)</p>";
}
?>