<?php if((get_the_ID()==504)||(get_the_ID()==511)||(get_the_ID()==592)) {?>
<div style="color:#333;font-size:14px;font-family:Calibri,Arial,sans-serif;line-height:normal;float:left;width:240px;margin-left:32px">

 <div style="border:1px solid #CCC;padding:9px;height:290px;position:relative;">
   <div style="padding:7px;position:absolute;left:-4px;background:#B85A10;top:20px;font-weight:bold;color:#fff;">Featured Project</div>
   <div style="background:#efefef">
   <?php if( is_page()){ ?>
     <?php switch(get_the_ID()){
        case 504:
             include (TEMPLATEPATH.'/placeholder/software-dev-project.php');
             break;
        
        case 511:
             include (TEMPLATEPATH.'/placeholder/data-entry-project.php');
             break;

        case 592:
             include (TEMPLATEPATH.'/placeholder/software-quality-project.php');
             break;
        }
      ?>
     <?php } ?>
     </div>
 </div>
</div>
<? if(get_the_ID()!=511){ ?>
<div style="background: none repeat scroll 0 0 #EEEEEE;border-radius: 10px 10px 10px 10px;color: #777777;float: left;   font-family: Calibri,Arial,sans-serif;margin-top: 40px;padding: 7px;width: 292px;">
  <div style="background: none repeat scroll 0 0 #FFFFFF;border-radius: 4px 4px 4px 4px;box-shadow: 0 -2px 40px inset;    min-height: 150px;position: relative;">
    <div style="padding:7px;font-weight:bold;font-size:18px;box-shadow:0 -1px 15px #eee;border:solid 1px #eaeaea;color:#555">Related Blogs</div>
      <?php if( is_page()){ ?>
       <?php switch(get_the_ID()){
        case 504:
             include (TEMPLATEPATH.'/placeholder/software-dev-blog.php');
             break;

        case 592:
             include (TEMPLATEPATH.'/placeholder/software-quality-blog.php');
             break;
        }
      ?>
     <?php } ?>
  </div>
</div>
<?php } ?>
<?php }?>