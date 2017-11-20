<?php
/**
 * This file will display reports for the logged in user.
 */
include('../header.php');
?>
<title>Keyword Concatenation Tool</title>
<style>
    body{
        background-color: #00d7fe;
    }
    .border_blue{
        border: 1px #0000ff solid;
    }
    .outter_div{
        /*background-color: #efebeb;*/
/*        background-color: #dcdbdb;*/
        background-color: #ffffff;
        width: 100%;
        float: left;
    }
    button{
/*        background-color: #617af7;
        border: 1px solid #617af7;
        color: white;*/
        width: 150px;
        height: 50px;
        /*border-radius: 5px;*/
        /*font-size: 20px;*/
        margin-top: 75px;
        cursor: pointer;
        /*font-family: SourceSansBold;*/
    }
    .inner_div{
        margin: 0 auto;
        width: 1200px;
        min-height: 500px;
    }
    .row_div{
        width: 1080px;
        min-height: 150px;
        margin: 0 auto;
    }
    .col_div{
        width: 358px;
        float: left;
        overflow: hidden;
        min-height: 150px;
    }
    .centered_100{
        width: 100%;
        margin: 0 auto;
    }
    .box-holder{
        /*border-top: 1px solid #fff;*/
        list-style-type: none;
        overflow: hidden;
        padding-top: 20px;
        text-align: center;
    }
    .check-holder {
        margin: 20px auto 10px;
        margin-bottom: 10px;
    }
    .box-holder li {
        float: left;
        list-style: none;
        margin: 10px 10px 0;
        width: 325px;
    }
    .box-holder .checkbox {
        margin: 0 auto;
    }
    .checkbox {
        cursor: pointer;
    }
    input {
        outline: medium none;
    }
    textarea, input {
        color: #333;
        font-family: helvetica,sans serif,arial;
        font-size: 13px;
        line-height: 18px;
/*        width: 275px;*/
    }
    textarea{
        background-color: #f1f0f0;
        border: 0 none;
        height: 270px;
        resize: none;
        width: 275px;
    }
    .last-row{
        padding: 0px;
    }
    .last-row textarea{
        height: 260px;
        width: 99%;
        float: left;
        padding: 5px;
    }
    .last-row button{
        margin-top: 10px;
        width: 300px;
        /*width: 330px;*/
    }
    .box-holder .keyword-box {
        /*background: #fff none repeat scroll 0 0;*/
        background: #f1f0f0 none repeat scroll 0 0;
        border: 4px solid #d2c1f9;
        border-radius: 10px;
        clear: both;
        height: 270px;
        padding: 5px;
        width: 275px;
    }
    .textarea-background-colour{
        background: #f1f0f0 none repeat scroll 0 0;
    }
    .second_row{
        
    }
    .second_row h3{
        width: 275px;
        text-align: left;
    }
    .second_row input{
        width: 20px;
        text-align: left;
        /*float: left;*/
    }
    .second_row label{
        text-align: left;
        /*float: left;*/
    }
    .second_row li{
        width: 325px;
        text-align: left;
        border-right: 1px solid #c1c1c1;
        min-height: 180px;
    }
    .second_row li:last-of-type{
        width: 325px;
        border-right: none;
        min-height: 180px;
    }
    .box-holder li p{
        text-align: left;
    }
    .perms input{
        width: 16%;
        text-align: left;
        float: left;
    }
    .perms label{
        width: 15%;
        text-align: left;
        float: left;
    }
    .line_bottom{
        width: 100%;
        border-bottom: 2px #00d7fe solid;
    }
    .last-row li{
        width: 98%;
    }
    .last-row div{
        width: 100%;
        border: 4px solid #d2c1f9;
        border-radius: 10px;
        min-height: 270px;
    }
    .full-width{
        
    }
</style>
<script type="text/javascript" src="../js/jquery-3.1.1.min.js" ></script>
<div class="outter_div">
    <div class="inner_div ">
        
        <div class="row_div "> 
            <ul id="" class="box-holder ui-sortable">
                <li>
                  <h3>A</h3>
                  <div class="check-holder">
                    <input class="checkbox tiptip ta_ckb" name="box-state" checked="checked" type="checkbox">
                  </div>
                  <a href="#" class="drag-tab tiptip"></a>
                  <div class="keyword-box textarea-background-colour">
                      <textarea name="a_box" tabindex="1" class="keyarea "></textarea>
                  </div>
                </li>
                <li>
                  <h3>B</h3>
                  <div class="check-holder">
                    <input class="checkbox tiptip ta_ckb" name="box-state" checked="checked" type="checkbox">
                  </div>
                  <a href="#" class="drag-tab tiptip"></a>
                  <div class="keyword-box textarea-background-colour">
                    <textarea name="b_box" tabindex="1" class="keyarea "></textarea>
                  </div>
                </li>
                <li>
                  <h3>C</h3>
                  <div class="check-holder">
                    <input class="checkbox tiptip ta_ckb" name="box-state" checked="checked" type="checkbox">
                  </div>
                  <a href="#" class="drag-tab tiptip"></a>
                  <div class="keyword-box textarea-background-colour">
                    <textarea name="c_box" tabindex="1" class="keyarea c_box"></textarea>
                  </div>
                </li>
            </ul>
            <div class="line_bottom"></div>
            <ul id="" class="box-holder ui-sortable second_row">
                
                <li class="m-type">
                    <h3>Match Types</h3>
                    <p class="select-all"><a href="#select">Select all</a> | <a href="#deselect">Deselect all</a></p>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" checked="true">
                    <label>Exact</label>
                    <br />
                    <input value="exact" name="operation" id="op-exact" type="checkbox">
                    <label>Phrase</label>
                    <br />
                    <input value="exact" name="operation" id="op-exact" type="checkbox">
                    <label>Modified broad match</label>
                </li>
                <li class="perms">
                    <h3>Permutations</h3>
                    <p class="select-all"><a href="#select">Select all</a> | <a href="#deselect">Deselect all</a></p>
                    <div class="combo_item">
                        
                        
                    </div>
                    
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all" checked="true">
                    <label class="all">A,B,C</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all">
                    <label class="all">A,C,B</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all">
                    <label class="all">B,A,C</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all">
                    <label class="all">B,C,A</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all">
                    <label class="all">C,A,B</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox" class="all">
                    <label class="all">C,B,A</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twoab">
                    <label  class="twoab">A,B</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twoab">
                    <label  class="twoab">B,A</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twoac">
                    <label  class="twoac">A,C</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twoac">
                    <label  class="twoac">C,A</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twobc">
                    <label  class="twobc">B,C</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="twobc">
                    <label  class="twobc">C,B</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="aone">
                    <label  class="aone">A</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="bone">
                    <label  class="bone">B</label>
                    <input value="exact" name="operation" id="op-exact" type="checkbox"  class="cone">
                    <label  class="cone">C</label>
                </li>
                <li>
                    <button  type="button" name="concatenate"  class="keyconcatenate" >Concatenate</button>
                </li>
                
                
            </ul>
            <div class="line_bottom"></div>
            <ul id="" class="box-holder ui-sortable last-row">
                
                <li>
                    <h3 id="opt_hdng">0 Results - 0 results over 25 characters long</h3>
                </li>
                <li>
                    <div class="textarea-background-colour">
                        <textarea id="opt_area"></textarea>
                    </div>
                    <button id="concatenate_button" type="button" name="concatenate" >With Symbols</button>&nbsp;
                    <button id="long_keywords_button" type="button" name="concatenate" >No Keywords Over 25 Characters</button>&nbsp;
                    <button id="rest_all_button" type="button" name="concatenate" >Reset all</button>
                </li>
            </ul>
        </div>
        
        
    </div>
</div>
<script type="text/javascript">
    var resultArray = [];
    var broadResultArray = [];
    $("#opt_area").val("");
    $(document).ready(function(){
//        $("#opt_area").val("");
//        $(".ta_ckb").prop("checked",true);
//        $(".ta_ckb").parent().next().next().find("textarea").removeAttr("disabled");
//        $(".ta_ckb").parent().next().next().find("textarea").removeAttr("readonly");
//        $(".ta_ckb").parent().next().next().find("textarea").css("cursor","text");
//        $(".second_row input").prop("checked",false);
//        $(".second_row input").first().prop("checked",true);
        $(".all").css("display","block");
        $(".twoab").css("display","block");
        $(".twobc").css("display","block");
        $(".twoac").css("display","block");
        $(".aone").css("display","none");
        $(".bone").css("display","none");
        $(".cone").css("display","none");
        $(".ta_ckb").click();
        $("#rest_all_button").click();
    });
    $(".ta_ckb").click(function(){
        var input_characters=[];// = ["A", "B", "C"];
        $(".ta_ckb").each(function(){
            if($(this).prop("checked")){
                input_characters.push($(this).parent().parent().find('h3').text());
            }
        });
        
        if($(this).prop("checked")){
            $(this).parent().next().next().find("textarea").removeAttr("disabled");
            $(this).parent().next().next().find("textarea").removeAttr("readonly");
            $(this).parent().next().next().find("textarea").css("cursor","text");

            if(input_characters.length==3){
                $(".all").css("display","block");
                $(".twoab").css("display","block");
                $(".twobc").css("display","block");
                $(".twoac").css("display","block");
                $(".aone").css("display","none");
                $(".bone").css("display","none");
                $(".cone").css("display","none");
            }

            if(input_characters.length==2){
                $(".all").css("display","none");
                $(".twoab").css("display","none");
                $(".twobc").css("display","none");
                $(".twoac").css("display","none");
                $(".aone").css("display","none");
                $(".bone").css("display","none");
                $(".cone").css("display","none");
                if(input_characters.indexOf('A')==-1)
                {
                    $(".twobc").css("display","block");
                }
                if(input_characters.indexOf('B')==-1)
                {
                    $(".twoac").css("display","block");
                }
                if(input_characters.indexOf('C')==-1)
                {
                    $(".twoab").css("display","block");
                }
            }
        }else{
            if(input_characters.length>0){
            
                $(this).parent().next().next().find("textarea").attr("disabled","disabled");
                $(this).parent().next().next().find("textarea").attr("readonly","readonly");
                $(this).parent().next().next().find("textarea").css("cursor","not-allowed");

                //restrict to single one

                var removed = $(this).parent().parent().find('h3').text();
                var index = input_characters.indexOf(removed);
                if (index > -1) {
                    input_characters.splice(index, 1);
                }

                if(input_characters.length==2){
                     $(".all").css("display","none");
                    $(".twoab").css("display","none");
                    $(".twobc").css("display","none");
                    $(".twoac").css("display","none");
                    if(input_characters.indexOf('A')==-1)
                    {
                        $(".twobc").css("display","block");
                    }
                    if(input_characters.indexOf('B')==-1)
                    {
                        $(".twoac").css("display","block");
                    }
                    if(input_characters.indexOf('C')==-1)
                    {
                        $(".twoab").css("display","block");
                    }
                }
                if(input_characters.length==1){
                     $(".all").css("display","none");
                    $(".twoab").css("display","none");
                    $(".twobc").css("display","none");
                    $(".twoac").css("display","none");
                    if(input_characters.indexOf('A')>-1)
                    {
                        $(".aone").css("display","block");
                    }
                    if(input_characters.indexOf('B')>-1)
                    {
                        $(".bone").css("display","block");
                    }
                    if(input_characters.indexOf('C')>-1)
                    {
                        $(".cone").css("display","block");
                    }
                }

            }
            else
            {
                return false;
            }
            
            
        }
    });
    $(".m-type a").click(function(){
        if($.trim($(this).text()) === "Select all"){
            $(".m-type").find("input").prop("checked",true);
        }else{
            $(".m-type").find("input").prop("checked",false);
        }
    });
    $(".perms a").click(function(){
        if($.trim($(this).text()) === "Select all"){
            $(".perms").find("input").prop("checked",true);
        }else{
            $(".perms").find("input").prop("checked",false);
        }
    });
    
    $(".keyconcatenate").click(function(){
        $("#opt_area").slideUp();
        var wordArray1 = [];
        var wordArray2 = [];
        var wordArray3 = [];
        $("#opt_area").val("");
        resultArray = [];
        broadResultArray = [];
        
        var enabledTextareaCount = 0;
        $(".keyarea").each(function(){
            if($(this).attr("disabled")!="disabled"){
                var textareaVal = $.trim($(this).val());
                var j = 0;
                
                var dummy = '';
                for(i=0;i<textareaVal.length;i++){
                    var charTxt = textareaVal.charAt(i);
                    var charCode = textareaVal.charCodeAt(i);
                    dummy += charTxt;
                    if((charCode === 10 || (i+1) === textareaVal.length)){
//                    if((charCode === 10 || (i+1) === textareaVal.length) && dummy!==''){
                        if($(this).attr("name") === "a_box" && ($.inArray(dummy,wordArray1)===-1)){
                            wordArray1[j] = dummy.toLowerCase();
                        } 
                        if($(this).attr("name") === "b_box" && ($.inArray(dummy,wordArray2)===-1)){
                            wordArray2[j] = dummy.toLowerCase();
                        }
                        if($(this).attr("name") === "c_box" && ($.inArray(dummy,wordArray3)===-1)){
                            wordArray3[j] = dummy.toLowerCase();
                        }
                        j++;
                        dummy = '';
                    }
                }
                j++;
                enabledTextareaCount++;
            }
        });
        var permutations = [];
        var iVal = 0;
        $(".perms input").each(function(){
            if($(this).css("display")!='none' && $(this).prop("checked")){
                permutations[iVal] = ($(this).next().text());
                iVal++;
            }
        });
        var matchTypes = [];
        iVal = 0;
        $(".m-type input").each(function(){
            if($(this).prop("checked")){
                matchTypes[iVal] = ($(this).next().text());
                iVal++;
            }
        });
        
        iVal = 0;
        
        $.each(permutations, function( index, value ) {
            if($.inArray("Exact",matchTypes)!=-1){
                if(value === "A,B,C"){
                    ThreeLoopExact(wordArray1,wordArray2,wordArray3);
                }else if(value === "A,C,B"){
                    ThreeLoopExact(wordArray1,wordArray3,wordArray2);
                }else if(value === "B,A,C"){
                    ThreeLoopExact(wordArray2,wordArray1,wordArray3);
                }else if(value === "B,C,A"){
                    ThreeLoopExact(wordArray2,wordArray3,wordArray1);
                }else if(value === "C,A,B"){
                    ThreeLoopExact(wordArray3,wordArray1,wordArray2);
                }else if(value === "C,B,A"){
                    ThreeLoopExact(wordArray3,wordArray2,wordArray1);
                }else if(value === "A,B"){
                    TwoLoopExact(wordArray1, wordArray2);
                }else if(value === "B,A"){
                    TwoLoopExact(wordArray2, wordArray1);
                }else if(value === "A,C"){
                    TwoLoopExact(wordArray1, wordArray3);
                }else if(value === "C,A"){
                    TwoLoopExact(wordArray3, wordArray1);
                }else if(value === "B,C"){
                    TwoLoopExact(wordArray2, wordArray3);
                }else if(value === "C,B"){
                    TwoLoopExact(wordArray3, wordArray2);
                }else if(value === "A"){
                    OneLoopExact(wordArray1);
                }else if(value === "B"){
                    OneLoopExact(wordArray2);
                }else if(value === "C"){
                    OneLoopExact(wordArray3);
                }
            }
            if($.inArray("Phrase",matchTypes)!=-1){
                if(value === "A,B,C"){
                    ThreeLoopPhrase(wordArray1, wordArray2, wordArray3);
                }else if(value === "A,C,B"){
                    ThreeLoopPhrase(wordArray1, wordArray3, wordArray2);
                }else if(value === "B,A,C"){
                    ThreeLoopPhrase(wordArray2, wordArray1, wordArray3);
                }else if(value === "B,C,A"){
                    ThreeLoopPhrase(wordArray2, wordArray3, wordArray1);
                }else if(value === "C,A,B"){
                    ThreeLoopPhrase(wordArray3, wordArray1, wordArray2);
                }else if(value === "C,B,A"){
                    ThreeLoopPhrase(wordArray3, wordArray2, wordArray1);
                }else if(value === "A,B"){
                    TwoLoopPhrase(wordArray1, wordArray2);
                }else if(value === "B,A"){
                    TwoLoopPhrase(wordArray2, wordArray1);
                }else if(value === "A,C"){
                    TwoLoopPhrase(wordArray1, wordArray3);
                }else if(value === "C,A"){
                    TwoLoopPhrase(wordArray3, wordArray1);
                }else if(value === "B,C"){
                    TwoLoopPhrase(wordArray2, wordArray3);
                }else if(value === "C,B"){
                    TwoLoopPhrase(wordArray3, wordArray2);
                }else if(value === "A"){
                    OneLoopPhrase(wordArray1);
                }else if(value === "B"){
                    OneLoopPhrase(wordArray2);
                }else if(value === "C"){
                    OneLoopPhrase(wordArray3);
                }
            }
            if($.inArray("Modified broad match",matchTypes)!=-1){
                if(value === "A,B,C"){
                    ThreeLoopModified(wordArray1, wordArray2, wordArray3);
                }else if(value === "A,C,B"){
                    ThreeLoopModified(wordArray1, wordArray3, wordArray2);
                }else if(value === "B,A,C"){
                    ThreeLoopModified(wordArray2, wordArray1, wordArray3);
                }else if(value === "B,C,A"){
                    ThreeLoopModified(wordArray3, wordArray2, wordArray1);
                }else if(value === "C,A,B"){
                    ThreeLoopModified(wordArray3, wordArray1, wordArray2);
                }else if(value === "C,B,A"){
                    ThreeLoopModified(wordArray3, wordArray2, wordArray1);
                }else if(value === "A,B"){
                    TwoLoopModified(wordArray1, wordArray2);
                }else if(value === "B,A"){
                    TwoLoopModified(wordArray2, wordArray1);
                }else if(value === "A,C"){
                    TwoLoopModified(wordArray1, wordArray3);
                }else if(value === "C,A"){
                    TwoLoopModified(wordArray3, wordArray1);
                }else if(value === "B,C"){
                    TwoLoopModified(wordArray2, wordArray3);
                }else if(value === "C,B"){
                    TwoLoopModified(wordArray3, wordArray2);
                }else if(value === "A"){
                    OneLoopModified(wordArray1);
                }else if(value === "B"){
                    OneLoopModified(wordArray2);
                }else if(value === "C"){
                    OneLoopModified(wordArray3);
                }
            }
        });
        var total = resultArray.length;
        var longTotal = 0;
        $("#opt_area").val("");
        var currVal = $("#opt_area").val();
        $("#opt_area").slideUp(0,function(){
            $.each(resultArray, function( index, value ) {
                if(value.length>25){
                    longTotal++;
                }
                if(currVal===''){
                    currVal = value;
                }else{
                    currVal = currVal+"\n"+value;
                }
            });
            $("#opt_area").val(currVal);
            $("#opt_area").slideDown(1000,function(){

            });
        });
        
        $("#opt_hdng").text(total+" Results - "+longTotal+" results over 25 characters long");
        $("#opt_area")[0].scrollIntoView({
            behavior: "smooth", // or "auto" or "instant" smooth
            block: "start" // or "end"
        });
    });
    
    $("#concatenate_button").click(function(){
        $("#opt_area").val("");
        var currVal = $("#opt_area").val();
        $("#opt_area").slideUp(0,function(){
            $.each(resultArray, function( index, value ) {
                if(currVal===''){
                    currVal = value;
                }else{
                    currVal = currVal+"\n"+value;
                }
            });
            $("#opt_area").val(currVal);
            $("#opt_area").slideDown(1000,function(){

            });
        });
    });
    
    $("#long_keywords_button").click(function(){
        $("#opt_area").val("");
        var currVal = $("#opt_area").val();
        $("#opt_area").slideUp(0,function(){
            $.each(resultArray, function( index, value ) {
                if(value.length<25){
                    if(currVal===''){
                        currVal = value;
                    }else{
                        currVal = currVal+"\n"+value;
                    }
                }
            });
            $("#opt_area").val(currVal);
            $("#opt_area").slideDown(1000,function(){

            });
        });
    });
    $("#rest_all_button").click(function(){
        $("#opt_area").val("");
        $(".ta_ckb").prop("checked",true);
        $(".ta_ckb").parent().next().next().find("textarea").removeAttr("disabled");
        $(".ta_ckb").parent().next().next().find("textarea").removeAttr("readonly");
        $(".ta_ckb").parent().next().next().find("textarea").css("cursor","text");
        $(".second_row input").prop("checked",false);
        $(".second_row input").first().prop("checked",true);
        $(".all").css("display","block");
        $(".twoab").css("display","block");
        $(".twobc").css("display","block");
        $(".twoac").css("display","block");
        $(".aone").css("display","none");
        $(".bone").css("display","none");
        $(".cone").css("display","none");
        $(".perms input").first().prop("checked",true);
        $("#opt_hdng").text("0 Results - 0 results over 25 characters long");
        $(".keyarea").val("");
        $(".inner_div")[0].scrollIntoView({
            behavior: "smooth", // or "auto" or "instant" smooth
            block: "start" // or "end"
        });
        resultArray = [];
        broadResultArray = [];
    });
    
    function ThreeLoopExact(wordArray1, wordArray2, wordArray3){
        if(wordArray1.length>0 && wordArray2.length>0 && wordArray3.length>0){
            $.each(wordArray1, function( index1, value1 ) {
                $.each(wordArray2, function( index2, value2 ) {
                    $.each(wordArray3, function( index3, value3 ) {
                        var opt = "["+value1+" "+value2+" "+value3+"]";
                        if($.inArray(opt,resultArray)===-1){
                            resultArray.push(opt);
                        }
                    });
                });
            });
        }else if(wordArray1.length>0 && wordArray2.length>0){
            TwoLoopExact(wordArray1, wordArray2);
        }else if(wordArray2.length>0 && wordArray3.length>0){
            TwoLoopExact(wordArray2, wordArray3);
        }else if(wordArray3.length>0 && wordArray1.length>0){
            TwoLoopExact(wordArray3, wordArray1);
        }else if(wordArray1.length>0){
            OneLoopExact(wordArray1);
        }else if(wordArray2.length>0){
            OneLoopExact(wordArray2);
        }else if(wordArray3.length>0){
            OneLoopExact(wordArray3);
        }
        
    }
    function ThreeLoopPhrase(wordArray1, wordArray2, wordArray3){
        if(wordArray1.length>0 && wordArray2.length>0 && wordArray3.length>0){
            $.each(wordArray1, function( index1, value1 ) {
                $.each(wordArray2, function( index2, value2 ) {
                    $.each(wordArray3, function( index3, value3 ) {
                        var opt = '"'+value1+' '+value2+' '+value3+'"';
                        if($.inArray(opt,resultArray)===-1){
                            resultArray.push(opt);
                        }
                    });
                });
            });
        }else if(wordArray1.length>0 && wordArray2.length>0){
            TwoLoopPhrase(wordArray1, wordArray2);
        }else if(wordArray2.length>0 && wordArray3.length>0){
            TwoLoopPhrase(wordArray2, wordArray3);
        }else if(wordArray3.length>0 && wordArray1.length>0){
            TwoLoopPhrase(wordArray3, wordArray1);
        }else if(wordArray1.length>0){
            OneLoopPhrase(wordArray1);
        }else if(wordArray2.length>0){
            OneLoopPhrase(wordArray2);
        }else if(wordArray3.length>0){
            OneLoopPhrase(wordArray3);
        }
    }
    function ThreeLoopModified(wordArray1, wordArray2, wordArray3){
        if(wordArray1.length>0 && wordArray2.length>0 && wordArray3.length>0){
            $.each(wordArray1, function( index1, value1 ) {
                $.each(wordArray2, function( index2, value2 ) {
                    $.each(wordArray3, function( index3, value3 ) {
                        
                        var splitArray1 = value1.split(" ");
                        var optV1 = '';
                        if(splitArray1.length>1){
                            optV1 = ConcatenateArrayModified(splitArray1);
                        }else{
                            if($.inArray('+'+value1,broadResultArray)===-1){
                                optV1 = '+'+value1;
                                broadResultArray.push(optV1);
                            }
                        }
                        
                        var splitArray2 = value2.split(" ");
                        var optV2 = '';
                        if(splitArray2.length>1){
                            optV2 = ConcatenateArrayModified(splitArray2);
                        }else{
                            if($.inArray('+'+value2,broadResultArray)===-1){
                                optV2 = '+'+value2;
                                broadResultArray.push(optV2);
                            }
                        }
                        var splitArray3 = value3.split(" ");
                        var optV3 = '';
                        if(splitArray3.length>1){
                            optV3 = ConcatenateArrayModified(splitArray3);
                        }else{
                            if($.inArray('+'+value3,broadResultArray)===-1){
                                optV3 = '+'+value3;
                                broadResultArray.push(optV3);
                            }
                        }
                        var opt = optV1+' '+optV2+' '+optV3;
                        opt = $.trim(opt);
                        if(opt!==""){
                            if(splitArray1.length<=1 && splitArray2.length<=1 && splitArray3.length<=1){
                                if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray('+'+value3,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value1,broadResultArray)===-1){
                                    broadResultArray.push('+'+value1);
                                }
                                if($.inArray('+'+value2,broadResultArray)===-1){
                                    broadResultArray.push('+'+value2);
                                }
                                if($.inArray('+'+value3,broadResultArray)===-1){
                                    broadResultArray.push('+'+value3);
                                }
                            }else if(splitArray1.length<=1 && splitArray2.length<=1){
                                if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value1,broadResultArray)===-1){
                                    broadResultArray.push('+'+value1);
                                }
                                if($.inArray('+'+value2,broadResultArray)===-1){
                                    broadResultArray.push('+'+value2);
                                }
                            }else if(splitArray2.length<=1 && splitArray3.length<=1){
                                if(($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray('+'+value3,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value2,broadResultArray)===-1){
                                    broadResultArray.push('+'+value2);
                                }
                                if($.inArray('+'+value3,broadResultArray)===-1){
                                    broadResultArray.push('+'+value3);
                                }
                            }else if(splitArray1.length<=1 && splitArray3.length<=1){
                                if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray('+'+value3,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value1,broadResultArray)===-1){
                                    broadResultArray.push('+'+value1);
                                }
                                if($.inArray('+'+value3,broadResultArray)===-1){
                                    broadResultArray.push('+'+value3);
                                }
                            }else if(splitArray1.length<=1){
                                if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value1,broadResultArray)===-1){
                                    broadResultArray.push('+'+value1);
                                }
                            }else if(splitArray2.length<=1){
                                if(($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value2,broadResultArray)===-1){
                                    broadResultArray.push('+'+value2);
                                }
                            }else if(splitArray3.length<=1){
                                if(($.inArray('+'+value3,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }else if(($.inArray(opt,resultArray)===-1)){
                                    resultArray.push(opt);
                                }
                                if($.inArray('+'+value3,broadResultArray)===-1){
                                    broadResultArray.push('+'+value3);
                                }
                            }
                        }
                        
                    });
                });
            });
        }else if(wordArray1.length>0 && wordArray2.length>0){
            TwoLoopModified(wordArray1, wordArray2);
        }else if(wordArray2.length>0 && wordArray3.length>0){
            TwoLoopModified(wordArray2, wordArray3);
        }else if(wordArray3.length>0 && wordArray1.length>0){
            TwoLoopModified(wordArray3, wordArray1);
        }else if(wordArray1.length>0){
            OneLoopModified(wordArray1);
        }else if(wordArray2.length>0){
            OneLoopModified(wordArray2);
        }else if(wordArray3.length>0){
            OneLoopModified(wordArray3);
        }
        
    }
    function TwoLoopExact(wordArray1, wordArray2){
        $.each(wordArray1, function( index1, value1 ) {
            $.each(wordArray2, function( index2, value2 ) {
                var opt = "["+value1+" "+value2+"]";
                if($.inArray(opt,resultArray)===-1){
                    resultArray.push(opt);
                }
            });
        });
    }
    function TwoLoopPhrase(wordArray1, wordArray2){
        $.each(wordArray1, function( index1, value1 ) {
            $.each(wordArray2, function( index2, value2 ) {
                var opt = '"'+value1+' '+value2+'"';
                if($.inArray(opt,resultArray)===-1){
                    resultArray.push(opt);
                }
            });
        });
    }
    function TwoLoopModified(wordArray1, wordArray2){
        $.each(wordArray1, function( index1, value1 ) {
            $.each(wordArray2, function( index2, value2 ) {
                var splitArray1 = value1.split(" ");
                var optV1 = '';
                if(splitArray1.length>1){
                    optV1 = ConcatenateArrayModified(splitArray1);
                }else{
                    if($.inArray('+'+value1,broadResultArray)===-1){
                        optV1 = '+'+value1;
                        broadResultArray.push(optV1);
                    }
                }
                var splitArray2 = value2.split(" ");
                var optV2 = '';
                if(splitArray2.length>1){
                    optV2 = ConcatenateArrayModified(splitArray2);
                }else{
                    if($.inArray('+'+value2,broadResultArray)===-1){
                        optV2 = '+'+value2;
                        broadResultArray.push(optV2);
                    }
                }
                
                var opt = optV1+' '+optV2;
                opt = $.trim(opt);
                if(opt!==""){
                    if(splitArray1.length<=1 && splitArray2.length<=1){
                        if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                            resultArray.push(opt);
                        }
                        if($.inArray('+'+value1,broadResultArray)===-1){
                            broadResultArray.push('+'+value1);
                        }
                        if($.inArray('+'+value2,broadResultArray)===-1){
                            broadResultArray.push('+'+value2);
                        }
                    }else if(splitArray1.length<=1){
                        if(($.inArray('+'+value1,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                            resultArray.push(opt);
                        }else if(($.inArray(opt,resultArray)===-1)){
                            resultArray.push(opt);
                        }
                        if($.inArray('+'+value1,broadResultArray)===-1){
                            broadResultArray.push('+'+value1);
                        }
                    }else if(splitArray2.length<=1){
                        if(($.inArray('+'+value2,broadResultArray)===-1)&&($.inArray(opt,resultArray)===-1)){
                            resultArray.push(opt);
                        }else if(($.inArray(opt,resultArray)===-1)){
                            resultArray.push(opt);
                        }
                        if($.inArray('+'+value2,broadResultArray)===-1){
                            broadResultArray.push('+'+value2);
                        }
                    }
                }
            });
        });
    }
    function OneLoopExact(wordArray1){
        $.each(wordArray1, function( index1, value1 ) {
            var opt = "["+value1+"]";
            if($.inArray(opt,resultArray)===-1){
                resultArray.push(opt);
            }
        });
    }
    function OneLoopPhrase(wordArray1){
        $.each(wordArray1, function( index1, value1 ) {
            var opt = '"'+value1+'"';
            if($.inArray(opt,resultArray)===-1){
                resultArray.push(opt);
            }
        });
    }
    function OneLoopModified(wordArray1){
        $.each(wordArray1, function( index1, value1 ) {
            var splitArray = value1.split(" ");
            var opt = '';
            if(splitArray.length>1){
                opt = ConcatenateArrayModified(splitArray);
            }else{
                opt = '+'+value1;
            }
            if((splitArray.length>1)&&($.inArray(opt,resultArray)===-1)){
                resultArray.push(opt);
            }else if(($.inArray(opt,resultArray)===-1)){
                resultArray.push(opt);
            }
            if($.inArray('+'+value1,broadResultArray)===-1){
                broadResultArray.push('+'+value1);
            }
        });
    }
    function ConcatenateArrayModified(strArray){
        var result = "";
        $.each(strArray, function( index, value ) {
            if(($.inArray('+'+value,broadResultArray)===-1)){
                broadResultArray.push('+'+value);
                result += " +"+value;
            }
        });
        result = $.trim(result);
        return result;
    }
</script>

<?php include('../footer.php'); ?>
